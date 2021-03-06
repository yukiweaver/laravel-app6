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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'auth'], function () {
  Route::post('user/logout', 'UserController@logout')->name('user.logout');
  Route::get('user/status', 'UserController@status')->name('user.status');
});

Route::group(['middleware' => 'guest'], function() {
  Route::get('user/signin', 'UserController@signin')->name('user.signin');
  Route::post('user/login', 'UserController@login')->name('user.login');
  Route::get('user/signup', 'UserController@signup')->name('user.signup');
  Route::post('user/store', 'UserController@store')->name('user.store');
});

Route::get('/', 'QuestionController@index')->name('root');
Route::get('question/problem_statement', 'QuestionController@problemStatement')->name('question.problem_statement');
Route::post('question/answer', 'QuestionController@answer')->name('question.answer');