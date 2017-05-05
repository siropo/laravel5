<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@welcome');
Route::get('about', 'PageController@about');
Route::get('contact', 'PageController@contact');
Route::get('foo', ['middleware' => 'moderator', function() {
    return 'only for moderators';
}]);
Route::resource('articles', 'ArticleController');
Route::get('ads/getcategories', 'AdsController@getCategories');
Route::post('ads/imageUpload', 'AdsController@imageUpload');
Route::post('ads/imageDelete', 'AdsController@imageDelete');
Route::resource('ads', 'AdsController');

//Route::get('articles', 'ArticleController@index');
//Route::get('articles/create', 'ArticleController@create');
//Route::get('articles/{id}', 'ArticleController@show');
//Route::post('articles', 'ArticleController@store');


//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('tags/{tags}', 'TagsController@show');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);

Route::auth();

Route::get('/home', 'HomeController@index');
