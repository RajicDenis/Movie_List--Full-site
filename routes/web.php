<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'visitors'], function() {

	Route::get('/', function () {
    	return view('login');
	})->name('login');

	Route::post('login', ['uses' => 'LoginController@login'])->name('user-login');

	Route::get('login-page', ['uses' => 'LoginController@index'])->name('login-form');

	Route::post('register', ['uses' => 'RegistrationController@register'])->name('register');

});

Route::group(['middleware' => 'users'], function() {

	Route::get('news', 'NewsController@index');

	Route::get('profile/account', 'ProfileController@showAccount');
	Route::post('profile/account/update', 'ProfileController@updateAccount');
	Route::post('profile/account', 'ProfileController@uploadAvatar');
	Route::get('profile/account/remove', 'ProfileController@removeAvatar');
	Route::get('profile/myReviews', 'ProfileController@showReviews');
	Route::get('profile/myLikes', 'ProfileController@showLikes');
	Route::get('showProfile/{id}', 'ProfileController@showProfile');
	Route::get('showProfile/userReviews/{id}', 'ProfileController@userReviews');

	Route::post('logout', ['uses' => 'LoginController@logout'])->name('logout');

	Route::get('movielist', 'MovieListController@index');

	Route::get('movielist/createList', 'MovieListController@createList');

	Route::post('movielist/createList', 'MovieListController@storeList');

	Route::get('movielist/{id}', 'MovieListController@switchList');

	Route::post('browse/add', 'MovieListController@addMovie');

	Route::get('remove/{lid?}/{mid?}', 'MovieListController@remove'); 

	Route::post('movielist', 'MovieListController@addScore');
	Route::get('movielist/share/{id}', 'MovieListController@shareList');
	Route::get('movielist/delete/{id}', 'MovieListController@deleteList');

	Route::post('rating', 'MovieController@rateMovie');

	Route::post('showMovie/addReview', 'ReviewController@addReview');

	Route::post('showMovie/like', 'MovieController@likeMovie');

	Route::post('reviews/like', 'ReviewController@likeReview');

	Route::get('userlists', 'MovieListController@showUserlists');

	Route::get('showList/{uid}/{mid}', 'MovieListController@showList')->name('showList');

});

Route::group(['middleware' => 'admin'], function() {

	Route::post('settings/addgenre', 'GenreController@store');
	
	Route::get('settings/{id}', 'GenreController@remove');

	Route::get('settings', 'MovieController@index');

	Route::post('settings', 'MovieController@store');

	Route::get('settings/{id}/edit', 'MovieController@edit');

	Route::post('settings/{id}/edit', 'MovieController@update');

	Route::post('settings/{id}', 'MovieController@remove');

});

Route::get('info', function () {
    return view('info');
});


Route::get('browse/{year}/{order?}', 'BrowseController@index');

Route::get('browseTV/{year}/{order?}', 'BrowseController@indexTV');

Route::get('showMovie/{id}', 'BrowseController@showMovie');

Route::get('reviews', 'ReviewController@index');
Route::get('TVreviews', 'ReviewController@indexTV');

Route::get('reviews/{mid}/{uid}', 'ReviewController@showReview');

Route::get('test', function() {
	return view('test');
});

