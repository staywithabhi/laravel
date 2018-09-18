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
Route::get('staff',['as'=>'viewStaff','uses'=>'StaffController@index','middleware'=>'roles','roles'=>['admin']]);
Route::get('addNewStaff',['as'=>'addNewStaff','uses'=>'StaffController@addNewStaff','middleware'=>'roles','roles'=>['admin']]);
Route::get('userDelete/{id}',['as'=>'userDelete','uses'=>'StaffController@destroy','middleware'=>'roles','roles'=>['admin']]);
Route::get('userEdit/{id}',['as'=>'userEdit','uses'=>'StaffController@edit','middleware'=>'roles','roles'=>['admin']]);
Route::put('updateUser/{id}',['as'=>'updateUser','uses'=>'StaffController@update','middleware'=>'roles','roles'=>['admin']]);
Route::post('saveStaff',['as'=>'save','uses'=>'StaffController@save','middleware'=>'roles','roles'=>['admin']]);
/*Routes For Clients*/
Route::get('clients',['as'=>'clients','uses'=>'ClientController@index','middleware'=>'roles','roles'=>['standard','admin']]);
Route::get('clientAdd',['as'=>'clientAdd','uses'=>'ClientController@addNewClient','middleware'=>'roles','roles'=>['standard','admin']]);
Route::get('clientDelete/{id}',['as'=>'clientDelete','uses'=>'ClientController@destroy','middleware'=>'roles','roles'=>['standard','admin']]);
Route::get('clientEdit/{id}',['as'=>'clientEdit','uses'=>'ClientController@edit','middleware'=>'roles','roles'=>['standard','admin']]);
Route::put('clientUpdate/{id}',['as'=>'clientUpdate','uses'=>'ClientController@update','middleware'=>'roles','roles'=>['standard','admin']]);
Route::post('clientSave',['as'=>'clientSave','uses'=>'ClientController@save','middleware'=>'roles','roles'=>['standard','admin']]);




/**End routes for clients**/ 



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
