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

Route::get('forgot/password','ForgotController@showForgotPass')->name('forgot.pass');
Route::post('forgot/password','ForgotController@checkForgotPass');

Route::get("forgot/username",'ForgotController@showForgotUsername')->name('forgot.username');
Route::post("forgot/username",'ForgotController@checkForgotUsername');

/*
 *  Routes for registering
 */
Route::get('register','MyRegisterController@showRegistrationForm')->name('register');
Route::post('register','MyRegisterController@register');

/**
 * Routes for validation of account/passwordReset/usernameReset
 */
Route::get('validate/email/{token?}','Validate@showEmailValidation');
Route::post('validate/email','Validate@emailValidation');

Route::get('validate/username/{token?}','Validate@showResetUsername');
Route::post('validate/username','Validate@ResetUsername');

Route::get('validate/password/{token?}','Validate@showResetPassword');
Route::post('validate/password','Validate@ResetPassword');

Route::get('validate/{token?}','Validate@showValidationForm');
Route::get('validate','Validate@showValidationForm')->name('validation');
Route::post('validate','Validate@myValidate');

/**
 * Routes for profile related things
 */
Route::get('profile','profile\ProfileController@showProfile')->name('profile');
Route::get("profile/edit",'profile\ProfileController@editProfile');
Route::post('profile/edit','profile\ProfileController@makeEditProfile');

Route::get('profile/show/{name}','profile\ProfileController@showOtherProfile');
Route::get('profile/edit/{name}','profile\ProfileController@editOtherProfile');
Route::post('profile/edit/{name}','profile\ProfileController@makeEditOtherProfile');

Route::get("profile/avatar/{name}",'profile\ProfileController@editProfilePicture');
Route::post("profile/avatar/{name}",'profile\ProfileController@makeEditProfilePicture');

Route::get('profile/password','profile\ProfileController@showPassChange');
Route::post('profile/password','profile\ProfileController@EditPassword');

Route::get('profile/username','profile\ProfileController@showUsernameChange');
Route::post('profile/username','profile\ProfileController@EditUsername');

Route::get('profile/email','profile\ProfileController@showEmailChange');
Route::post('profile/email','profile\ProfileController@EditEmail');

/**
 * Routes for the AdminPanel
 */

Route::get("adminPanel","AdminPanelController@showPanel");
Route::get("adminPanel/Users/{rank?}",'AdminPanelController@showUsers');
Route::get("adminPanel/ContentGroups",'AdminPanelController@showContentGroups');
Route::get('adminPanel/UserGroups','AdminPanelController@showUserGroups');
Route::get('adminPanel/bannedPosts','AdminPanelController@showBanned');
Route::get('adminPanel/levels','AdminPanelController@showLevels');

Route::post("adminPanel/Users",'AdminPanelController@editUsers');
Route::post("adminPanel/bannedPosts",'AdminPanelController@unbanPost');
Route::post('adminPanel/levels','AdminPanelController@editLevels');

/**
 * Routes for displaying special permissions of users or groups
 */

Route::get('profile/specialperm/{name?}','profile\SpecialPermController@showSpecialPerm');
Route::get('group/specialperm/{name}','profile\SpecialPermController@showUserGroup');
Route::get('content/specialperm/{name}','profile\SpecialPermController@showContentGroup');
Route::get('group/specialperm/{name}/add','profile\SpecialPermController@addUserGroup');
Route::get('content/specialperm/{name}/add','profile\SpecialPermController@addContentGroup');
Route::post('specialPermission/add','profile\SpecialPermController@editGroup');
Route::post('specialPermission','profile\SpecialPermController@deleteSpecialPerm');
Route::post('new/specialperm','profile\SpecialPermController@newGroup');


/**
 * Routes for Messages
 */
Route::get('message','MessageController@showMessages');
Route::get('message/send/{link?}','MessageController@showsend');
Route::get('message/inbox','MessageController@showInbox');
Route::get('message/outbox','MessageController@showOutbox');
Route::get('message/view/{id}','MessageController@showMessage');

Route::post('message/send','MessageController@sendMessage');
Route::post('message','MessageController@deleteMessage');
Route::post('message/view/{id}','MessageController@replyMessage');

/**
 * Routes for the Maintopics
 */
Route::post('forum/new','forum\MainTopicController@makeNewMainTopic');
Route::get('forum/new','forum\MainTopicController@showNewMainTopics')->name('newMainTopic');

Route::get('forum','forum\MainTopicController@showMainTopics');
Route::post('forum','forum\MainTopicController@editMainTopic');

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