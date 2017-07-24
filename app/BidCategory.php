<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidCategory extends Model
{
    protected $fillable = ['name', 'parent_id'];

    public function bids()
    {
    	return $this->hasMany(Bid::class,'category_id');
    }
}
