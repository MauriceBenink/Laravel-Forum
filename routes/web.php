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

Route::get('login','MyLoginController@index')->name('login');
Route::post('login','MyLoginController@login');
Route::post('logout','MyLoginController@logout')->name('logout');

Route::post('password/email','MyLoginController@SendResetEmail');
Route::get('password/reset','MyLoginController@ShowResetForm')->name('password.request');
Route::post('password/reset','MyLoginController@reset');
Route::get('password/reset/{token}','MyLoginController@ShowResetForm');

Route::get('register','MyRegisterController@showRegistrationForm')->name('register');
Route::post('register','MyRegisterController@register');

Route::get('validate/{token?}','Validate@showValidationForm');
Route::get('validate','Validate@showValidationForm')->name('validation');
Route::post('validate','Validate@myValidate');


Route::post('forum/new','forum\MainTopicController@makeNewMainTopic');
Route::get('forum/new','forum\MainTopicController@showNewMainTopics')->name('newMainTopic');
Route::get('forum','forum\MainTopicController@showMainTopics');



Route::post('forum/{maintopic}/new','forum\SubTopicController@makeNewSubTopic');
Route::get('forum/{maintopic}/new','forum\SubTopicController@showNewSubTopic')->name("newSubTopic");
Route::get("forum/{maintopic}",'forum\SubTopicController@showSubTopics');

Route::post('forum/{maintopic}/{subtopic}/new','forum\PostsController@makeNewPost');
Route::get("forum/{maintopic}/{subtopic}/new",'forum\PostsController@showNewPost')->name('newPost');
Route::get("forum/{maintopic}/{subtopic}",'forum\PostsController@showPosts');

Route::post('forum/{maintopic}/{subtopic}/{post}/new','forum\CommentController@makeNewComment');
Route::get('forum/{maintopic}/{subtopic}/{post}/new','forum\CommentController@showNewComment')->name('newComment');
Route::get('forum/{maintopic}/{subtopic}/{post}','forum\CommentController@showComments');
Route::post("forum/{maintopic}/{subtopic}/{post}",'forum\CommentController@editComment');
Route::get('forum/{maintopic}/{subtopic}/{post}/{comment}/edit','forum\CommentController@showeditComment')->name('editComment');
Route::post('forum/{maintopic}/{subtopic}/{post}/{comment}/edit','forum\CommentController@makeEditComment');


Route::get('/home','HomeController@index')->name('home');