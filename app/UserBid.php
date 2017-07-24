<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBid extends Model
{
    protected $fillable = ['user_id', 'bid_id', 'data', 'status'];

    public function bid()
    {
    	return $this->belongsTo(Bid::class);
    }
}
