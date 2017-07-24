<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    public static function listExcept(array $excepts)
    {
    	return self::whereNotIn('name', $excepts)->get();
    }

    public static function bidResponsibles()
    {
    	return self::where('bid_responsible', 1)->get();
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }

    // public function permissions()
    // {
    //     return $this->belongsToMany(Voyager::modelClass('Permission'));
    // }

}
