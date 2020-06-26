<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/post/{id}','PostController@index')->name('view-post');
Auth::routes();

//for logged in routes
Route::middleware(['auth'])->group(function(){
    Route::get('/admin-profile/{id}','UserController@getUserProfile')->name('admin-profile');
    Route::get('/view-profile/{id}','UserController@getProfile')->name('view-profile');
    Route::post('/save-profile','UserController@saveProfile')->name('save-profile');
    Route::get('/change-password/{id}','UserController@getPasswordView')->name('password-view');
    Route::post('/save-password','UserController@savePassword')->name('save-password');
    Route::get('/admin','AdminController@index')->name('admin');
    Route::get('/getusers','UserController@getUsers')->name('users');
    Route::get('/getposts','PostController@getPosts')->name('posts');
    Route::get('/manageuser/{id?}','UserController@getUser')->name('manage-user');
    Route::get('/managepost/{id?}','PostController@getPost')->name('manage-post');
    Route::post('/saveuser','UserController@saveUser')->name('save-user');
    Route::post('/savepost','PostController@savePost')->name('save-post');
    Route::delete('/deleteuser/{id}','UserController@deleteUser')->name('delete-user');
    Route::delete('/deletepost/{id}','PostController@deletePost')->name('delete-post');
});
//end

