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

/*
 * Routes for loggin in and out
 */
Route::get('login','MyLoginController@index')->name('login');
Route::post('login','MyLoginController@login');
Route::post('logout','MyLoginController@logout')->name('logout');

/*
 * Currently unused
 */
Route::post('password/email','MyLoginController@SendResetEmail');
Route::get('password/reset','MyLoginController@ShowResetForm')->name('password.request');
Route::post('password/reset','MyLoginController@reset');
Route::get('password/reset/{token}','MyLoginController@ShowResetForm');

/*
 *  Routes for registering
 */
Route::get('register','MyRegisterController@showRegistrationForm')->name('register');
Route::post('register','MyRegisterController@register');

/**
 * Routes for validation of account/passwordReset/usernameReset
 */
Route::get('validate/{token?}','Validate@showValidationForm');
Route::get('validate','Validate@showValidationForm')->name('validation');
Route::post('validate','Validate@myValidate');

/**
 * Routes for the Maintopics
 */
Route::post('forum/new','forum\MainTopicController@makeNewMainTopic');
Route::get('forum/new','forum\MainTopicController@showNewMainTopics')->name('newMainTopic');
Route::get('forum','forum\MainTopicController@showMainTopics');
Route::post('forum','forum\MainTopicController@editMainTopic ');
Route::get('forum/{maintopic}/edit','forum\MainTopicController@showEditMainTopic')->name('editMainTopic');
Route::post('forum/{maintopic}/edit','forum\MainTopicController@makeEditMainTopic');

/**
 * Route for the SubTopics
 */
Route::post('forum/{maintopic}/new','forum\SubTopicController@makeNewSubTopic');
Route::get('forum/{maintopic}/new','forum\SubTopicController@showNewSubTopic')->name("newSubTopic");
Route::get("forum/{maintopic}",'forum\SubTopicController@showSubTopics');
Route::post("forum/{maintopic}",'forum\SubTopicController@editSubTopic');
Route::get("forum/{maintopic}/{subtopic}/edit",'forum\SubtopicController@showEditSubTopic')->name('editSubTopic');
Route::post("forum/{maintopic}/{subtopic}/edit",'forum\SubtopicController@makeEditSubTopic');

/**
 * Routes for the Posts
 */
Route::post('forum/{maintopic}/{subtopic}/new','forum\PostsController@makeNewPost');
Route::get("forum/{maintopic}/{subtopic}/new",'forum\PostsController@showNewPost')->name('newPost');
Route::get("forum/{maintopic}/{subtopic}",'forum\PostsController@showPosts');
Route::post("forum/{maintopic}/{subtopic}",'forum\PostsController@editPosts');
Route::get('forum/{maintopic}/{subtopic}/{post}/edit','forum\PostsController@showEditPost')->name('editPost');
Route::post('forum/{maintopic}/{subtopic}/{post}/edit','forum\PostsController@makeEditPost');

/**
 * Routes for the Comments
 */
Route::post('forum/{maintopic}/{subtopic}/{post}/new','forum\CommentController@makeNewComment');
Route::get('forum/{maintopic}/{subtopic}/{post}/new','forum\CommentController@showNewComment')->name('newComment');
Route::get('forum/{maintopic}/{subtopic}/{post}','forum\CommentController@showComments');
Route::post("forum/{maintopic}/{subtopic}/{post}",'forum\CommentController@editComment');
Route::get('forum/{maintopic}/{subtopic}/{post}/{comment}/edit','forum\CommentController@showEditComment')->name('editComment');
Route::post('forum/{maintopic}/{subtopic}/{post}/{comment}/edit','forum\CommentController@makeEditComment');


Route::get('/home','HomeController@index')->name('home');