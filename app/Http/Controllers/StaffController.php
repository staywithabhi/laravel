<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Input;
// use App\Http\Controllers\Auth;
use Auth;
use App\User;
use App\Role;
use DB;
use Hash;
use Validator;
use Image;

class StaffController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request,Builder $htmlbuilder)
    {
        $id = Auth::user()->id;
        // echo "id is:-".$id;
        // exit;
        if($request->ajax())
        {
            // $id = Auth::user()->getId();
            $staff=DB::table('users')->select(['id','name','email','usertype','avatar'])
            ->whereNotIn('id', [$id])->get();
            return Datatables::of($staff)
            ->addColumn('action', function($row) {
                return '<a href="/userEdit/'. $row->id .'" class="btn btn-primary">Edit</a>
                <a data-href="/userDelete/'. $row->id .'" class="btn btn-danger" title="Delete" data-toggle="modal" data-target="#confirm-delete">Delete</a>';
            })
            ->make(true);
        }
        $html= $htmlbuilder
        // ->addColumn(['data'=>'id','name'=>'id','title'=>'Id'])
        ->addColumn(['data'=>'name','name'=>'name','title'=>'Name'])
        ->addColumn(['data'=>'email','name'=>'email','title'=>'Email'])
        ->addColumn(['data'=>'usertype','name'=>'usertype','title'=>'User Type'])
        ->addColumn([
            'data'=>'avatar',
            'name'=>'avatar',
            'title'=>'Avatar',
            'render' => '"<img src=\"/uploads/avatars/"+data+"\" height=\"50\"/>"',
            'orderable'      => false,
            'searchable'     => false,
            'exportable'     => false,
            'printable'      => true,
            'footer'         => '',
            ])
        ->addColumn([
            'defaultContent' => '',
            'data'           => 'action',
            'name'           => 'delete',
            'title'          => 'Actions',
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
       
        try {
 
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
        if($request->input('usertype'))
        {
            $usertype = $request->input('usertype');
            $role_user=Role::where('name',$usertype)->first();
            // echo "role type is<pre>";
            // print_r($role_user);
            // exit;
            // $user->usertype= $usertype;
            $user->roles()->attach($role_user);
        }
        $request->session()->flash('alert-success', 'User was added successfully!');

    }
    catch(\Illuminate\Database\QueryException $e){
        $errorCode = $e->errorInfo[1];
        if($errorCode == '1062'){
            $request->session()->flash('alert-danger', 'Another record with same email already exists');

        }
    }
        return redirect()->action('StaffController@index');
    }

    public function edit($id)
    {
        $staff=User::find($id);
      
        if($staff){

            return view('edituser')->with('staff',$staff);  
        }
        else{
         
            $msg ='Sorry, User can not be found';
            $type='warning';
            return redirect()->action('StaffController@index')
                        ->with($type,$msg);
        }
    }

     public function update($id,Request $request)
    {
        // echo "abhios";
        // exit;
        $rules=array(
        'name' => 'required|max:255',
        'email' => 'required|email|max:255',
        'usertype' => 'required',
        // 'password' => 'required|min:6|confirmed',
        // 'accept_terms' => 'required|accepted',
        );
        $validator=Validator::make(Input::all(),$rules);
        $this->validate($request, ['name'=>'required']);
        if($validator->fails()){
            return redirect('userEdit/'.$id)->withErrors($validator)->withInput();
        }
        else{
            $user=User::find($id);
            $user->name=Input::get('name');
            $user->email=Input::get('email');
            $user->usertype=Input::get('usertype');
            if(Input::get('password')){
                $hashed = Hash::make(Input::get('password'));
                $user->password= $hashed;
                // $user->password=Input::get('email')
            }
            if($request->hasFile('avatar'))
            {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
                $user->avatar = $filename;
            }
            $user->save();
            $user->roles()->detach();
            if(Input::get('usertype')){
            $role_user=Role::where('name',Input::get('usertype'))->first();
            $user->roles()->attach($role_user);
            }
            // $user->roles()->attach($role_user);

            $request->session()->flash('alert-success', 'User was updated successfully!');
            return redirect()->action('StaffController@index');

        }
        # code...
    }



    public function destroy($id)
    {
        $user=User::find($id);
        if($user){
            $user->delete();
           $msg ='User deleted successfully';
           $type='success';
        }
        else{
            $msg ='Sorry, User can not be found';
            $type='warning';
        }
        return redirect()->action('StaffController@index')
                        ->with($type,$msg);
    }
}
