<?php

namespace App;

use App\Poll;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
	protected $fillable = ['name', 'poll_id', 'votes'];
    public function poll()
    {
    	return $this->belongsTo(Poll::class, 'poll_id');
    }
    public function users()
    {
    	return $this->belongsToMany(User::class, 'votes');
    }
}
