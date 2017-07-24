<?php

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
    	\Jdate::setLocale('ru');
	    return view('main.index');
	});

	Route::get('/logout', 'Auth\LoginController@logout');

	Route::get('articles/anchored','ArticleController@anchored');
	Route::post('articles/{article}/comment', 'ArticleController@comment');
	Route::get('articles/search-bar','Api\SearchController@articleBar');
	Route::get('articles/search-submit','Api\SearchController@articleSubmit');
	// Route::get('articles/{article}/highlight','Api\SearchController@articleHighlight');
	Route::resource('articles', 'ArticleController');
	Route::get('articleRights', 'Api\SearchController@articleRights');


	Route::get('users/search-bar','Api\SearchController@userBar');
	Route::get('users/search-submit','Api\SearchController@userSubmit');
	Route::get('users/pdcgetdata','Api\SearchController@receive_pdc');
	Route::resource('users', 'UserController');

	Route::resource('documents', 'DocumentController');
	Route::get('bids', 'BidController@index');
	Route::get('bids/{bid}', 'BidController@show');
	Route::post('bids/{bid}', 'BidController@place');

	Route::post('poll', 'PollController@vote');

	Route::group(['prefix' => 'admin'], function () {

    	Voyager::routes();		
    	Route::post('articles', 'Admin\ArticleController@store');
    	Route::put('articles/{article}', 'Admin\ArticleController@update');

		Route::get('import-users', 'Admin\UserController@import');
		Route::get('import-users/step-2', 'Admin\UserController@importStep2');
		Route::post('import-users', 'Admin\UserController@importHandle');
		Route::post('import-users/step-2', 'Admin\UserController@importStep2Handle');

		Route::post('users', 'Admin\UserController@store');
		Route::put('users/{user}', 'Admin\UserController@update');
		Route::delete('users/{user}', 'Admin\UserController@destroy');

		Route::post('polls', 'Admin\PollController@store');
		Route::put('polls/{poll}', 'Admin\PollController@update');

		Route::resource('bids', 'Admin\BidController');
		Route::get('bid-categories', 'Api\BidCategoryController@getList');

		Route::get('heads', 'Admin\UserController@heads');
		Route::get('hr_managers', 'Admin\UserController@hrManagers');
		Route::post('heads', 'Admin\UserController@storeRoles');
		Route::get('dismissed', 'Admin\UserController@dismissed');
		Route::post('dismissed/{user}', 'Admin\UserController@undismiss');
		Route::post('hr_managers', 'Admin\UserController@storeRoles');
		Route::post('infos', 'Admin\InfosController@store');

		Route::get('b_image', function(){
			return view('admin.b_image');
		});
		Route::post('b_image', function()
		{ 
			Storage::disk('public')->delete('background.jpg');
			if(isset(request()->background))
				Storage::putFileAs('public', request()->file('background'), 'background.jpg');
			return back();
		});
	});
});
