<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleUser extends Model
{
    protected $fillable = ['user_id', 'article_id'];
}
