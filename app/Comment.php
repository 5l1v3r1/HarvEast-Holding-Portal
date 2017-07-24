<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;

class Comment extends Model
{
    use LocalizedEloquentTrait;
    protected $fillable = ['body','user_id', 'article_id', 'parent_id'];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function article()
    {
    	return $this->belongsTo(Article::class);
    }
}
