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
Route::get('staff',['as'=>'viewStaff','uses'=>'StaffController@index','middleware'=>'roles','roles'=>['admin','staff-readonly','staff-readwrite']]);
Route::get('addNewStaff',['as'=>'addNewStaff','uses'=>'StaffController@addNewStaff','middleware'=>'roles','roles'=>['admin','staff-readwrite']]);
Route::get('userDelete/{id}',['as'=>'userDelete','uses'=>'StaffController@destroy','middleware'=>'roles','roles'=>['admin','staff-readwrite']]);
Route::get('userEdit/{id}',['as'=>'userEdit','uses'=>'StaffController@edit','middleware'=>'roles','roles'=>['admin','staff-readwrite']]);
Route::put('updateUser/{id}',['as'=>'updateUser','uses'=>'StaffController@update','middleware'=>'roles','roles'=>['admin','staff-readwrite']]);
Route::post('saveStaff',['as'=>'save','uses'=>'StaffController@save','middleware'=>'roles','roles'=>['admin','staff-readwrite']]);
/*Routes For Clients*/

Route::get('filter/{postdata}',['as'=>'filter','uses'=>'ClientController@filterClient','middleware'=>'roles','roles'=>['client-readonly','admin','client-readwrite']]);
Route::get('clients',['as'=>'clients','uses'=>'ClientController@index','middleware'=>'roles','roles'=>['client-readonly','admin','client-readwrite']]);
Route::get('clientAdd',['as'=>'clientAdd','uses'=>'ClientController@addNewClient','middleware'=>'roles','roles'=>['client-readwrite','admin']]);
Route::get('client/delete/{id}',['as'=>'clientDelete','uses'=>'ClientController@destroy','middleware'=>'roles','roles'=>['client-readwrite','admin']]);
Route::get('client/edit/{id}',['as'=>'editClient','uses'=>'ClientController@edit','middleware'=>'roles','roles'=>['client-readwrite','admin']]);
Route::put('client/update/{id}',['as'=>'clientUpdate','uses'=>'ClientController@update','middleware'=>'roles','roles'=>['client-readwrite','admin']]);
Route::post('clientSave',['as'=>'clientSave','uses'=>'ClientController@save','middleware'=>'roles','roles'=>['client-readwrite','admin']]);

Route::get('/members/manage/{id}',['as'=>'manage','uses'=>'MemberController@index','middleware'=>'roles','roles'=>['client-readonly','admin','client-readwrite']]);
Route::get('/members/add/{id}',['as'=>'addMember','uses'=>'MemberController@addMemberToClient','middleware'=>'roles','roles'=>['client-readwrite','admin']]);
// Route::post('/members/save',['as'=>'memberSave','uses'=>'MemberController@saveMemberToClient','middleware'=>'roles','roles'=>['standard','admin']]);
Route::post('memberSave',['as'=>'memberSave','uses'=>'MemberController@saveMemberToClient','middleware'=>'roles','roles'=>['client-readwrite','admin']]);
Route::get('memberDelete/{id}',['as'=>'memberDelete','uses'=>'MemberController@destroy','middleware'=>'roles','roles'=>['admin','client-readwrite']]);
Route::get('memberEdit/{id}',['as'=>'memberEdit','uses'=>'MemberController@edit','middleware'=>'roles','roles'=>['admin','client-readwrite']]);
Route::put('member/update/{id}',['as'=>'memberUpdate','uses'=>'MemberController@update','middleware'=>'roles','roles'=>['client-readwrite','admin']]);





/**End routes for clients**/ 



Route::auth();


Route::get('/','UserController@home')->middleware('auth');
Route::get('/home','UserController@home')->middleware('auth');
// Route::group(['middleware' => 'auth'], function () {
//     //    Route::get('/link1', function ()    {
// //        // Uses Auth Middleware
// //    });

//     //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
//     #adminlte_routes
// });
