<?php

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


/*
Route::get('/', function () {
    return view('welcome');
});
*/



Auth::routes();

//temporary





Route::post('follow/{user}',[App\Http\Controllers\FollowsController::class,'store'])->name('store');



/**Here the routes need to be in particular order, anything with variable need to be at the end after you match all the routes according to resource controller documentation */



Route::get('/',[App\Http\Controllers\PostsController::class,'index'])->name('posts.index');
Route::get('/p/create',[App\Http\Controllers\PostsController::class,'create'])->name('posts.create');

Route::post('/p',[App\Http\Controllers\PostsController::class,'store'])->name('posts.store');

Route::get('/p/{post}',[App\Http\Controllers\PostsController::class,'show'])->name('posts.show');

Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.show');


Route::get('/profile/{user}/edit',[App\Http\Controllers\ProfilesController::class,'edit'])->name('profile.edit');

Route::patch('/profile/{user}',[App\Http\Controllers\ProfilesController::class,'update'])->name('profile.update');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



