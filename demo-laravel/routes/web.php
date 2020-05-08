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

Route::get('/', function () {
	return view('welcome');
});

Route::prefix('article')->group(function () {
	Route::post('add', 'ArticleController@article');
	Route::post('edit', 'ArticleController@article');
	Route::post('del', 'ArticleController@delArticle');
	Route::post('list', 'ArticleController@listArticle');
});