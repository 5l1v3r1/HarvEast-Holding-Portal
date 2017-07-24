<?php

namespace App\Providers;

use App\Article;
use App\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         \View::composer('*', function ($view) {
            $users = User::with(['city','department','position','role'])->where('is_active', 1)->get();
            $view->with('users', $users);
        });
         \View::composer('*', function ($view) {
            $articles = Article::with(['city','department'])->get();
            $view->with('articles', $articles);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VoyagerBreadController::class, Voyager\MyBreadController::class);
    }
}
