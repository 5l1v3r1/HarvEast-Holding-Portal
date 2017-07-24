<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\City;
use App\Department;
use App\Http\Controllers\Controller;
use App\Position;
use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function articleBar()
    {
        return Article::miniList();
    }

    public function articleSubmit()
    {
        $page = request()->has('page') ? request()->page : 1;
        $article = array_values(Article::list()->forPage($page, 2)->toArray());
        return count($article) ? response()->json($article) : '';
    }

    public function userBar()
    {
        return User::find(6);
    }
    public function userSubmit()
    {
        return User::find();
    }
}
