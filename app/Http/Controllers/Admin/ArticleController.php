<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{  
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|max:255',
            'body' => 'required',
        ]);
    	$article = Auth::user()->publish();
        return redirect('/admin/articles/'.$article->id.'/edit')->with([
                'message'    => "Статья добавлена",
                'alert-type' => 'success',
            ]);
    }
    public function update(Article $article)
    {
        $this->validate(request(), [
            'name' => 'required|max:255',
            'body' => 'required',
        ]);
    	Auth::user()->publish($article);
    	return redirect('/admin/articles/'.$article->id.'/edit')->with([
                'message'    => "Статья добавлена",
                'alert-type' => 'success',
            ]);
    }
}
