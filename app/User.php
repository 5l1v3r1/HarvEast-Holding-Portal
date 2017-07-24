<?php

namespace App;

use App\Mail\BidRequest;
use App\Mail\UserRegister;
use App\Position;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use TCG\Voyager\Http\Controllers\VoyagerMediaController;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birthday', 'photo', 'city_id', 'department_id', 'position_id', 'boss_id', 'role_id', 'is_active'
    ];
    public $timestamps = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['IsHorizontalPhoto'];

    protected $dates = ['birthday'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function roleId()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Article::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public static function add()
    {        
        $request = self::prepare();
        $password = str_random(10);
        $request['password'] = bcrypt($password);    
        $user = User::create($request);

        if(isset($request['phone']))
        {
           foreach ($request['phone'] as $phone) {
            if($phone)                
               Phone::create(['phone' => $phone, 'user_id' => $user->id]);
           }
        }   

        \Mail::to($user->email)->send(new UserRegister($user, $password));
    }

    public function edit()
    {
        $request = self::prepare();

        if($this->phones->count())
        {            
            DB::table('phones')->where('user_id', $this->id)->delete();                      
        }
        if(isset($request['phone']))
        {
           foreach ($request['phone'] as $phone) {
            if($phone)
               Phone::create(['phone' => $phone, 'user_id' => $this->id]);
           }
        }       
        if(isset($request['boss_id']) && (int) $request['boss_id'])
        {
            unset($request['boss_id']);
        }
        $this->update($request);
    }

    public static function prepare()
    {
        $request = request()->all();
        if(request()->file('photo') !== null)
        {            
            $request['photo'] = '/storage/app/public/'.request()->file('photo')->store('users/'.$request['email'], 'public');
        }
        else
        {
            unset($request['photo']);
        }
        if(!isset($request['department_id']))
        {
            $request['department_id'] = Auth::user()->department->id;
        }

        if(!isset($request['city_id']))
        {
            $request['city_id'] = Auth::user()->city->id;
        }       

        $request['role'] = isset($request['role']) ? $request['role'] : Role::where('name', 'user')->first()->id;

        return $request;
    }

    public function publish($article = null)
    {   
        $tags = array_unique(array_map('trim', explode(',', request()->tags)));
        foreach ($tags as $tag) {    
            if($tag)
            {
                $existed = Tag::where('name', $tag)->first(); 
                if($existed === null)
                {                
                    $tgs[] = Tag::create(['name' =>$tag]);
                }
                else
                {
                    $tgs[] = $existed;
                } 
            }           
        }
        
        $request = request()->except(['tags']);
        $request['body'] = isset($request['body']) ? \BBCode::parse($request['body']) : 0;
        // $request['body'] = preg_replace("/(<\/h1>)/", "", $request['body']);
        // $request['body'] = preg_replace("/(<h1>)/", "", $request['body']);
        $request['is_anchored'] = isset($request['is_anchored']);
        $request['is_highlighted'] = isset($request['is_highlighted']); 
        $request['anchored_from'] = Carbon::parse($request['anchored_from']);
        $request['anchored_to'] = Carbon::parse($request['anchored_to']);
        $request['slug'] = \Slug::make($request['name'].'_'.Carbon::now()->toDateString());
        $request['city_id'] = isset($request['city_id']) ? $request['city_id'] : ($this->hasPermission('admin') ? null : $this->city_id);
        $request['department_id'] = isset($request['department_id']) ? $request['department_id'] : ($this->hasPermission('admin') ? null : $this->department_id);
        if(isset(request()->media))
        {
            $file = request()->file('media');
            $request['media'] = '<img src="/storage/app/public/articles/'.$request['slug'].'/'.$file->getClientOriginalName().'">';
            Storage::put('/public/articles/'.$request['slug'].'/'.$file->getClientOriginalName(), file_get_contents($file));
        }
        elseif(request()->has('rmfile'))
        {
            $request['media'] = '';
        }
        else
        {            
            preg_match('/src="([^"]+)"/', $request['body'], $res);
            if(isset($res[0]))
            {
                $res = preg_replace("/(\/)/", "\/", $res[0]);
                $res = preg_replace("/(\")/", '\"', $res);
                preg_match("|\<iframe [^>]*[".preg_quote($res, '/')."][^>].*?\<\/iframe>|", $request['body'], $output_array);
                if(isset($output_array[0]))
                {
                    $request['media'] = $output_array[0];
                }
                else
                {
                    preg_match("/<img [^>]*[".preg_quote($res, '/')."][^>]+>/", $request['body'], $output_array);
                    if(isset($output_array[0]))
                    {
                        $request['media'] = $output_array[0];
                    }
                }
            }                    
        }

        if(is_null($article)){
            $article = $this->articles()->create($request); 
        }
        else {
            $article->update($request);
        }
        ArticleTag::where('article_id', $article->id)->delete();
        if(isset($tgs))
        {
           foreach ($tgs as $tag) {
            ArticleTag::create([
                'tag_id' => $tag->id,
                'article_id' => $article->id,
                ]);
            } 
        }        
        return $article;
    }

    public static function hasVoted()
    {
        $poll = Poll::current();
        $options = $poll->options->pluck('id');
        $vote = Vote::whereIn('option_id', $options)
                    ->where('user_id', Auth::id())
                    ->first();
        return isset($vote->id) ? true : false; 
    }

    public static function todayBirthdays()
    {        
        return User::where('city_id', Auth::user()->city_id)
            // ->where('department_id', Auth::user()->department_id)
            ->whereMonth('birthday' , Carbon::today()->month)
            ->whereDay('birthday' , Carbon::today()->day)
            ->get(['id', 'name', 'birthday', 'photo']);
    }

    public static function monthBirthdays()
    {
        return User::where('city_id', Auth::user()->city_id)
            // ->where('department_id', Auth::user()->department_id)
            ->whereRaw("DATE_FORMAT( birthday, '%m-%d') > ?", Carbon::today()->format('m-d'))
            ->whereRaw("DATE_FORMAT( birthday, '%m-%d') <= ?", Carbon::today()->addDays(30)->format('m-d'))
            ->orderByRaw("DATE_FORMAT(birthday,'%m-%d')")
            ->get(['id', 'name', 'birthday', 'photo']);
    }

    public static function find($limit = 0)
    {
        $search = request()->has('search') ? request()->search : '';
        
        $department = request()->has('department') ? Department::where('id', request()->department)->first() : null;
        $city = request()->has('city') ? City::where('id', request()->city)->first() : null;
        $position = request()->has('position') ? Position::where('id', request()->position)->first() : null;



        if(!$search)
        {
            $user = "";
            if(isset($department) or isset($city) or isset($position))
            {
                $user = User::with(['city', 'department', 'position', 'phones']);
                if(isset($department))
                {
                    $user = $user->where('department_id', $department->id);
                }
                if(isset($city))
                {
                    $user = $user->where('city_id', $city->id);
                }
                if(isset($position))
                {
                    $user = $user->where('position_id', $position->id);                    
                }
                $user = $limit ? $user->limit($limit)->get() : $user->get();              
            }
            return $user;
        }
        $search_words = multiexplode(array(" ",",",".","|",":"), $search);
        foreach ($search_words as $key => $search_word)
        {
            if(is_null($city))
            {
                $city = City::where('name', 'like', "%$search_word%")->first();
                if(!is_null($city))
                {
                    unset($search_words[$key]);
                    continue;
                }
            }
            if(is_null($department))
            {
                $department = Department::where('name', 'like', "%$search_word%")->first();
                if(!is_null($department))
                {
                    unset($search_words[$key]);
                    continue;
                }
            }
            if(is_null($position))
            {
                $position = Position::where('name', 'like', "%$search_word%")->first();
                if(!is_null($position))
                {
                    unset($search_words[$key]);
                    continue;
                }
            }
        }
        $user = User::with(['city', 'department', 'position', 'phones']);
        $user = !is_null($city) ? $user->where('city_id', $city->id) : $user;
        $user = !is_null($department) ? $user->where('department_id', $department->id) : $user;
        $user = !is_null($position) ? $user->where('position_id', $position->id) : $user;
        if(!isset($search_words[0]))
        {
            return $limit ? $user->limit($limit)->get() : $user->get();
        }
        $user = $user->where('users.name', 'like', '%'.$search_words[0].'%');

        array_shift($search_words);
        if(empty($search_words))
        {
            return $limit ? $user->limit($limit)->get() : $user->get();
        }        
        foreach ($search_words as $key => $search_word)
        {
            if($search_word)
            {
                $user = $user->orWhere('users.name', 'like', '%'.$search_word.'%');
            }
        }
        dd($limit);
        return $limit ? $user->limit($limit)->get() : $user->get();
    }

    public static function filtered()
    {
        if(User::hasPermission('admin'))
        {
            return User::all();
        }
        return User::where('department_id', Auth::user()->department_id)
                    ->where('city_id', Auth::user()->city_id)
                    ->get();
    }

    public function placeBid($fields, Bid $bid)
    {
        $data = [];
        foreach ($fields as $key => $field)
        {
            if(isset(request()->all()[$key]))
            {
                if($field['label'])
                {
                    $data[$key]['label'] = $field['label'];
                }
                if($fields[$key])
                {
                    $data[$key]['value'] =  request()->all()[$key];  

                    if($field['field'] == 'files')
                    {
                        $fieldos = json_decode($bid->fields, true)[$key]['files'];
                        $chosens = isset(request()->all()[$key]) ? request()->all()[$key] : false;
                        if(isset($chosens))
                        {
                            if(is_array($chosens))
                            {
                                foreach ($chosens as $chosen)
                                {                           
                                    $files[] = $fields[$key]['files'][$chosen]['src'];
                                } 
                            }   
                            else
                            {
                                $files[] = $fields[$key]['files'][$chosens]['src'];
                            }       
                        }         
                        $data[$key]['value'] = 'attach';                                      
                    }
                    elseif($field['field'] == 'upload')
                    {
                        $filos = request()->file($key);
                        $path = 'public/bids/'.Auth::id().request()->name.'/';
                        $jPath = 'storage/app/public/bids/'.Auth::id().request()->name.'/';
                        $jFiles = '';
                        if(is_array($filos) && !empty($filos))
                        {           
                            foreach ($filos as $file) {                        
                                Storage::put($path.$file->getClientOriginalName(), file_get_contents($file));
                                $files[] = $jPath.$file->getClientOriginalName();
                            } 
                        }
                        elseif(isset($filos))
                        {
                            Storage::put($path.$filos->getClientOriginalName(), file_get_contents($files));
                            $files[] = $jPath.$filos->getClientOriginalName();
                        }    
                        $data[$key]['value'] = 'attach';
                    }
                }  
            }                      
        }            
        $data = serialize($data);
        $request = [
        'user_id' => Auth::id(),
        'bid_id' => $bid->id,
        'data' => $data,
        'status' => 'pending'
        ];
        $ub = UserBid::create($request);
        $files = isset($files) ? $files : false;
        \Mail::to($bid->email())->send(new BidRequest($this, $ub, $files));
    }

    public static function hasPermission($role='')
    {
        return $role ? (User::roleName() === $role || User::roleName() === 'admin') : User::roleName() !== 'user';
    }

    public static function roleName()
    {
        return Auth::user()->role->name;
    }

    public function coworkers($limit = 3)
    {
        $coworkers = User::where('department_id', $this->department_id)->get();
        if($coworkers->count() >= 3)
        {
            return $coworkers->random($limit);
        }
        return $coworkers;
    }

    public function roleInDepartment($role_id)
    {
        return User::where('city_id', $this->city_id)
            ->where('department_id', $this->department_id)
            ->where('role_id', $role_id)
            ->first();
    }

    public function isRole($role_id)
    {
        return $this->role->id == $role_id;
    }

    public static function storeRoles()
    {
        $users = User::whereIn('id', array_flatten(request()->head))->get();
        $user_role_id = Role::where('name', 'user')->first()->id;
        $role_id = request()->role;
        foreach ($users as $key => $user) {
            if(!$user->isRole($role_id))
            {
                $previous= $user->roleInDepartment($role_id);
                if(!is_null($previous))
                {
                    $previous->update(['role_id' => $user_role_id]);
                }
                $user->update(['role_id' => $role_id]);
            }
        }
    }

    public function getIsHorizontalPhotoAttribute()
    {
        list($width, $height) = getimagesize(str_replace('/storage/app', '', storage_path('app')).$this->photo);
        return ($width/$height) > 1;
    }
}
