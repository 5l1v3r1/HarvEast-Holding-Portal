<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Info extends Model
{
    protected $fillable = ['name', 'body', 'photo', 'city_id', 'department_id'];

    public static function current()
    {
    	$user = Auth::user();

    	return Info::where('city_id', $user->city_id)
    		->where('department_id', $user->department_id)
            ->whereNotNull('name')
            ->whereNotNull('body')
    		->first();
    }

    public static function exists($city_id, $department_id)
    {
        $info = self::where('city_id', $city_id)->where('department_id', $department_id)->first();
        return isset($info) ? $info : false;
    }

    public static function store()
    {
        foreach (request()->title as $city_id => $departments) {
            foreach ($departments as $department_id => $title) {
                $info = self::exists($city_id, $department_id);
                $body = \BBCode::parse(request()->body[$city_id][$department_id]);
                if(isset(request()->photo[$city_id][$department_id]))
                {
                    $file = request()->photo[$city_id][$department_id];
                    Storage::put('/public/infos/'.$file->getClientOriginalName(), file_get_contents($file));
                    $photo[$city_id][$department_id] = '/storage/app/public/infos/'.$file->getClientOriginalName();
                }
                elseif(!isset(request()->rmfile[$city_id][$department_id]))
                {
                    $photo[$city_id][$department_id] = isset($info->photo) ? $info->photo : null;
                }

                if($info)
                {
                    $info->update([
                        'city_id' => $city_id,
                        'department_id' => $department_id,
                        'name' => $title,
                        'photo' => (isset($photo[$city_id][$department_id]) ?$photo[$city_id][$department_id]: null),
                        'body' => $body
                    ]);
                }
                else
                {
                    self::create([
                        'city_id' => $city_id,
                        'department_id' => $department_id,
                        'name' => $title,
                        'photo' => (isset($photo[$city_id][$department_id]) ?: null),                        
                        'body' => $body
                    ]);
                }
            }
        }
    }
}
