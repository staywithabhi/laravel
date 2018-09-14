<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Datatables;
use App\User;
use DB;
use Hash;
use Image;

class StaffController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }


    public function index(Request $request,Builder $htmlbuilder)
    {
        // echo "hello";exit;
        if($request->ajax())
        {
            $staff=DB::table('users')->select(['id','name','email','avatar']);
            return Datatables::of($staff)->make(true);
        }
        // $staff=DB::table('users')->get();
        $html= $htmlbuilder
        ->addColumn([
            'defaultContent' => '<input type="checkbox" />',
            'title'          => '',
            'data'           => 'checkbox',
            'name'           => 'checkbox',
            'orderable'      => false,
            'searchable'     => false,
            'exportable'     => false,
            'printable'      => true,
            'width'          => '10px',
        ])
        ->addColumn(['data'=>'id','name'=>'id','title'=>'id'])
        ->addColumn(['data'=>'name','name'=>'name','title'=>'name'])
        ->addColumn(['data'=>'email','name'=>'email','title'=>'email'])
        ->addColumn(['data'=>'avatar','name'=>'avatar','title'=>'avatar'])
        ->addColumn([
            'defaultContent' => '<a href="#">Edit</a>',
            'data'           => 'action',
            'name'           => 'action',
            'title'          => 'Action',
            'render'         => null,
            'orderable'      => false,
            'searchable'     => false,
            'exportable'     => false,
            'printable'      => true,
            'footer'         => '',
        ])
        ->addColumn([
            'defaultContent' => '<a href="#">Delete</a>',
            'data'           => 'action',
            'name'           => 'action',
            'title'          => 'Action',
            'render'         => null,
            'orderable'      => false,
            'searchable'     => false,
            'exportable'     => false,
            'printable'      => true,
            'footer'         => '',
        ]);

        return view('staff')->with(compact('html'));
    }

    public function addNewStaff()
    {
        return view('addstaff');
    }

    public function save(Request $request)
    {
        $user= new User;
       

        if($request->input('name'))
        {
            $name = $request->input('name');
            $user->name= $name;
        }
        if($request->input('email'))
        {
            $email = $request->input('email');
            $user->email= $email;
        }
        if($request->input('password')){
            $hashed = Hash::make($request->input('password'));
            $user->password= $hashed;
            }
        if($request->input('remember_token'))
        {
            $remember_token = $request->input('remember_token');
            $user->remember_token= $remember_token;
        }
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
    		Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
            $user->avatar = $filename;
        }
        

        if($request->input('usertype'))
        {
            $usertype = $request->input('usertype');
            $user->usertype= $usertype;
        }

        $user->save();
    	// return view('staff')->with(compact('html'));
        // return view('staff');
        return redirect()->action('StaffController@index');
    }
}
