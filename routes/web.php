<?php

use App\Models\Page;
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

Route::get('/', PageController::class);

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', AdminController::class)->name('admin');

if(class_exists(Page::class) && Schema::hasTable('pages')){
    foreach (Page::all() as $page) {
        Route::get($page->url, $page->type);
    }
    Route::resource("pages", PageController::class);
}

Route::resource("sites", SiteController::class);
