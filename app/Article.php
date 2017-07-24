<?php

namespace App;

use App\City;
use App\Department;
use App\Mail\ArticleComment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Relations\Pivot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use \Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;
    use Searchable;

    public $asYouType = true;
    
	protected $fillable = ['name', 'body', 'media', 'slug', 'is_anchored', 'city_id', 'department_id','is_highlighted', 'anchored_from', 'anchored_to', 'views', 'user_id'];

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }       

	 /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];    

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tags');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add()
    {
        return (new self(request()))->save();
    }

    public function addComment()
    {
        $comment = request()->all();
        $comment['user_id'] = Auth::id();
        $created_comment = $this->comments()->create($comment);
        if(isset($comment['parent_id']))
        {
            $email = Comment::find($comment['parent_id'])->user->email;
            \Mail::to($email)->send(new ArticleComment($created_comment, $this->slug));
        }
    }


    public function setAnchor()
    {	
    	self::unsetAnchors();
        $this->update(['is_anchored' => 1, 'anchored_from' => Carbon::now()]);
    	return $this;
    }

    public function unsetAnchor()
    {
    	$this->update(['is_anchored' => 0]);

    	return $this;
    }

    public static function unsetAnchors()
    {
    	return self::where('is_anchored', 1)->update(['is_anchored' => 0]);
    }

    public static function anchored()
    {
        $anchored1 = self::where('is_anchored', 1)
            ->where('anchored_from', '<=', Carbon::now())
            ->where('anchored_to', '>', Carbon::now())
            ->get();
        $anchored2 = self::where('is_anchored', 1)
            ->where('anchored_from', '<=', Carbon::now())
            ->where('anchored_to', null)
            ->get();
        $anchored = $anchored1->merge($anchored2);
        return $anchored->whereIn('city_id', [Auth::user()->city_id, 0])
                        ->whereIn('department_id', [Auth::user()->department_id, 0])
                        ->first();
    }

    public static function relevant($limit = false)
    {
        $tag = request()->has('tag') ? request()->tag : false; 
        $tag = urldecode($tag);       
    	$articles = self::whereIn('city_id', [Auth::user()->city_id, 0])
                   ->whereIn('department_id', [Auth::user()->department_id, 0])
                   ->orderBy('created_at', 'desc');
        if($limit)
        {
            $articles->limit($limit);
        }
        $articles = $articles->with('tags')->get();
        foreach ($articles as $id => $article) {
            if($tag && !$article->tags->where('name', $tag)->count())
            {
                $articles->pull($id);
            }
            $article->body = str_limit(mediaLess($article->body), 1000, '...');
        }
        return $articles;
    }

    public static function miniList()
    {
        if(request()->has('search'))
        {
            return self::searchList(request()->search);
        }
        return [];
    }

    public static function list()
    {
        $search = request()->has('search') ? request()->search : '';
        $tag = request()->has('tag') ? request()->tag : false;
        $tag = urldecode($tag);
        if($search)
        {
            $articles = self::searchList($search);
            $articles->load('tags');
            foreach ($articles as $id => $article) 
            {
                if($tag && !$article->tags->where('name', $tag)->count())
                {
                    $articles->pull($id);
                }
                else
                {
                    $article->body = str_limit(mediaLess($article->body), 1000, '...');
                }
            }
        }
        else
        {
            $articles = Article::relevant();
        }      
        return $articles;
    }

    protected static function searchList($search)
    {
        $local = Article::searchByCityAndDepartment(
                $search,
                Auth::user()->city_id,
                Auth::user()->department_id
                );

            $department = Article::searchByCityAndDepartment(
                $search,
                0,
                Auth::user()->department_id
                );

            $city = Article::searchByCityAndDepartment($search, Auth::user()->city_id);

            $global = Article::searchByCityAndDepartment($search);
            return $local->merge($department)
                              ->merge($city)
                              ->merge($global);
    }

    protected static function searchByCityAndDepartment($search, $city_id = 0, $department_id = 0)
    {
        return Article::search($search)
                      ->where('city_id', $city_id)
                      ->where('department_id', $department_id)
                      ->get();
    }

    public function visit()
    {        
        $user_id = Auth::id();
        $article_id = $this->id;
        $view = ArticleView::where('user_id', $user_id)->where('article_id', $article_id)->first();
        if(!isset($view))
        {
            ArticleView::create(compact('user_id', 'article_id'));
            $this->views++;
            $this->save();
        }
        return $this;
    }

    public function getComments()
    {
        $comments = $this->comments()->where('parent_id', null)->get();
        $sub_comments = []; 
        foreach($comments as $comment)
        {
            $sub_comments[] = array_flatten([$this->getChildComments($comment)]);
        }
        return compact('comments', 'sub_comments');
    }

    public function getChildComments($comment)
    {
        $comments = Comment::with('user')->where('parent_id', $comment->id)->get();
        if($comments->count() == 0)
        {
            return false;
        }
        foreach($comments as $comment)
        {
            $result = $this->getChildComments($comment);
            if($result)
            {
                $comments[] = $result;             
            }
        }
        return $comments;
    }
}
