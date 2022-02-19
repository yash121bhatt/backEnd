<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('add-product','ProductController@productCreate');
// Route::get('product-list','ProductController@productList');

//add-register
// Route::post('add-student','registerController@studentCreate');

//login
// Route::post('add-login','loginController@login');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', 'JWTAuthController@register');
    Route::post('login', 'JWTAuthController@login');
    Route::post('logout', 'JWTAuthController@logout');
    Route::post('refresh', 'JWTAuthController@refresh');
    Route::get('profile', 'JWTAuthController@profile');
    //add-register
    Route::post('add-student','registerController@studentCreate');
    //login
     Route::post('add-login','loginController@login');
     //userDetails
     Route::get('userDetails','loginController@userDetails');

     //Category API

     //addCategory
     Route::post('add-Category','API\Category2Controller@addCategory');
     //listCategory
     Route::get('list-Category','API\Category2Controller@categoryList');
     //getCategory
    //  Route::get('userCategory','API\Category2Controller@userCategory');
     //deleteCategory
     Route::delete('delete-Category/{id}','API\Category2Controller@deleteCategory');
     //updateCategory
     Route::put('update-Category/{id}','API\Category2Controller@updateCategory');

     //Quiz API

     //addQuiz
     Route::post('add-quiz','API\QuizControlle@addQuiz');
     //listQuiz
     Route::get('list-quiz','API\QuizControlle@listQuiz');
     //editQuiz
     Route::post('update-quiz/{id}','API\QuizControlle@updateQuiz');
     //deleteQuiz
     Route::delete('delete-quiz/{id}','API\QuizControlle@deleteQuiz');
      //get Quiz
      Route::get('get-quiz/{catName}','API\QuizControlle@getQuiz');

     //Question API

     //add Question
     Route::post('add-ques','API\QestionControlle@addQuestion');
     //delete Question
     Route::delete('delete-ques/{id}','API\QestionControlle@deleteQuestion');
     //update Questio
     Route::post('update-ques/{id}','API\QestionControlle@updateQuestion');
     //list Question
     Route::get('list-ques/{quizId}','API\QestionControlle@listQuestion');
     //get Question
     Route::get('get-ques/{id}','API\QestionControlle@getQuestion');


});
