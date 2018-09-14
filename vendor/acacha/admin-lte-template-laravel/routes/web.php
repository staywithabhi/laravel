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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('dashboard', function () {
//     return view('dashboard');
// });
Route::get('profile','UserController@profile');
Route::post('profile','UserController@update_profile');
Route::get('staff',array('as'=>'viewStaff','uses'=>'StaffController@index'));
Route::get('addNewStaff',array('as'=>'addNewStaff','uses'=>'StaffController@addNewStaff'));
Route::post('saveStaff',array('as'=>'save','uses'=>'StaffController@save'));

Route::auth();


Route::get('/', function () {
    return view('home');
    })->middleware('auth');
// Route::group(['middleware' => 'auth'], function () {
//     //    Route::get('/link1', function ()    {
// //        // Uses Auth Middleware
// //    });

//     //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
//     #adminlte_routes
// });
