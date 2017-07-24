<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
	protected $fillable = ['phone', 'user_id'];
    protected $dates = [];
}
