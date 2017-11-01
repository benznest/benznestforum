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

Route::get('/', 'TopicController@getTopicAll');
Route::get('/home', 'TopicController@getTopicAll');
Route::get('/sorry','Auth\AuthController@showViewBanned');

Route::get('/search', function(){
	return view('search');
});
Route::get('/search/topic/','TopicController@searchTopic');

Route::get('/login', function(){
	return view('auth/login')->with("errors",array());;
});
Route::post('/auth/login','Auth\AuthController@authenticate');


Route::get('/contact', function(){
	return view('contact');
});
Route::get('/getForumName', 'ConfigForumController@getForumName');
Route::get('/favorite','FavoriteTopicController@getAllMyFavoriteTopic');



// category
Route::get('/category/{category_id}','TopicController@showViewTopicInCategory');

// topic
Route::get('/topic/new','TopicController@showViewNewTopic');
Route::post('/topic/new','TopicController@newTopic');
Route::get('/poll/new','TopicController@showViewNewTopicPoll');
Route::post('/poll/new','TopicController@newPollTopic');
Route::get('/topic/{topic_id}','TopicController@showViewTopicBody');

// comment
Route::post('/comment/new','CommentController@newComment');
Route::post('/subcomment/new','SubCommentController@newSubComment');
//Route::get('index','TopicController@getTopicAll');

// profile
Route::get('/profile', 'UserController@profile');
Route::post('/profile/save','UserController@saveChangeProfile');
Route::post('/profile/changepassword','UserController@changePassword');
Route::get('/profile/{users_id}','UserController@showViewUserProfile');

// vote
Route::get('/topic/{topic_id}/vote/{rating}','TopicController@voteRatingTopic');
Route::get('/topic/{topic_id}/{comment_id}/vote/{rating}','CommentController@voteRatingComment');

// poll vote
Route::post('/poll/vote','PollVoteController@addVote');

// Image
Route::post('/upload/image','ManagementController@uploadImage');
Route::get('/topic/resources/assets/img/{name_image}','ManagementController@getImage');

// Admin
Route::get('/admin','AdminController@showViewGeneralManagemane');
Route::get('/admin/general','AdminController@showViewGeneralManagemane');
Route::get('/admin/tag','AdminController@showViewTagManagement');
Route::get('/admin/category','AdminController@showViewCategoryManagement');
Route::get('/admin/account','AdminController@showViewAccountManagement');
Route::get('/admin/topic','AdminController@showViewTopicManagement');
Route::get('/admin/request','AdminController@showViewRequestManagement');
Route::get('/admin/statistics','AdminController@showViewStatistics');

// config forum
Route::post('/admin/change/nameforum/save','AdminController@changeForumName');

// category
Route::post('/admin/category/add','AdminController@addCategory');
Route::post('/admin/category/edit','AdminController@editCategory');
// tag

Route::post('/admin/tag/add','AdminController@addTag');
Route::post('/admin/tag/edit','AdminController@EditTag');

// account
Route::post('/admin/account/ban','AdminController@banAccount');
Route::post('/admin/account/recover','AdminController@recoverAccount');

// request
Route::post('/request/remove','RequestController@addRequest');

// favorite topic
Route::get('/favorite/add/topic/{topic_id}','FavoriteTopicController@addFavoriteTopic');
Route::get('/favorite/remove/{favorite_id}','FavoriteTopicController@removeFavoriteTopic');

Route::get('/report/category','ReportController@getDataReportCategory');
// //--------------------------------------------------------------

// Route::get('init', 'CategoryController@initializeData');
// Route::get('randomwallet','TransactionsController@generateSimpleData');
// Route::get('randomdiary','TransactionsController@generateSimpleDataDiary');



// Route::get('wallet/addTransactions','TransactionsController@showAddWalletTransaction');
// Route::post('wallet/addTransactions/new', 'TransactionsController@addTransaction');

// Route::get('wallet', 'TransactionsController@showAddWalletTransaction');
// Route::get('wallet/{page}/{num_page}','TransactionsController@showWalletTransactions');
// //Route::get('wallet/showAllTransactions/{page}','TransactionsController@showWalletTransactions');

// //Route::get('wallet/filter','TransactionsController@showWalletTransactions');
// Route::get('wallet/filter/{page?}/{num_page?}','TransactionsController@filter');
// Route::post('wallet/filter/{page?}','TransactionsController@filter');

// Route::post('wallet/search/{search?}/{page?}','TransactionsController@search');

// Route::get('wallet/summary', 'TransactionsController@summary');

// Route::get('/wallet/search',function(){
// 	return view('wallet/search');
// });

// Route::get('home', 'HomeController@index');



// Route::get ('diary/addDiary','DiaryController@showAddDiary');
// Route::get('diary/detail/{diary_id?}','DiaryController@detailDiary');
// Route::get('diary/edit/{diary_id?}','DiaryController@showEditDiary');
// Route::post('diary/edit/','DiaryController@editDiary');
// Route::get ('diary/{page}/{num_page}','DiaryController@showDiary');
// Route::post('diary/addDiary','DiaryController@addDiary');

// Route::post('diary/search/{search?}/{page?}','DiaryController@search');

// Route::get('diary/search',function(){
// 	return view('diary/search');
// });

// Route::get('diary/auth',function(){
// 	return view('auth/pin_diary');
// });




Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
