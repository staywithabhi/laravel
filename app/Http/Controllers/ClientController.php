<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Input;
use App\Clients;
use App\Role;
use DB;
use Hash;
use Validator;
use Image;

class ClientController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request,Builder $htmlbuilder)
    {
        if($request->ajax())
        {
            $clients=DB::table('clients')->select(['id','name','email','avatar']);
            return Datatables::of($clients)
            ->addColumn('action', function($row) {
                return '<a href="/clientEdit/'. $row->id .'" class="btn btn-primary">Edit</a>
                <a data-href="/clientDelete/'. $row->id .'" class="btn btn-danger" title="Delete" data-toggle="modal" data-target="#confirm-delete">Delete</a>';
            })
            ->make(true);
        }
        $html= $htmlbuilder
        // ->addCheckbox([
        //     'title'         =>'checkbox',
        //     'data'           => 'checkbox',
        //     'name'           => 'name',
        //     'id'             =>  'id',
        //     'value'          =>  'id',
        //     'orderable'      => false,
        //     'searchable'     => false,
        //     'exportable'     => false,
        //     'printable'      => true,
        //     'width'          => '10px',
        // ])
        ->addColumn(['data'=>'id','name'=>'id','title'=>'id'])
        ->addColumn(['data'=>'name','name'=>'name','title'=>'name'])
        ->addColumn(['data'=>'email','name'=>'email','title'=>'email'])
        ->addColumn(['data'=>'avatar','name'=>'avatar','title'=>'avatar'])
        ->addColumn([
            'defaultContent' => '',
            'data'           => 'action',
            'name'           => 'delete',
            'title'          => 'Action',
            'render'         => null,
            'orderable'      => false,
            'searchable'     => false,
            'exportable'     => false,
            'printable'      => true,
            'footer'         => '',
        ]);
        return view('clients.client')->with(compact('html'));
    }

    public function addNewClient()
    {
        return view('clients.addclient');
    }

    public function save(Request $request)
    {
        $user= new Clients;
    
       
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
        
        // echo "abhishekdd <pre>";
        // print_r($user);
        // exit;

        $user->save();
          $request->session()->flash('alert-success', 'Client was added successfully!');

    }
    catch(\Illuminate\Database\QueryException $e){
        $errorCode = $e->errorInfo[1];
        $request->session()->flash('alert-danger', 'Error Processing Your Request');
        if($errorCode == '1062'){
            $request->session()->flash('alert-danger', 'Another record with same email already exists');

        }
    }
        return redirect()->action('ClientController@index');
    }

    public function edit($id)
    {
        $user=Clients::find($id);
    //   echo "<pre>";
    //   print_r($user->name);
    //   exit;
        if($user){
            

            return view('clients.editclient')->with('user',$user);  
        }
        else{
           
            $msg ='Sorry, Client can not be found';
            $type='warning';
            return redirect()->action('ClientController@index')
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
            return redirect('clientEdit/'.$id)->withErrors($validator)->withInput();
        }
        else{

            $user=Clients::find($id);
            $user->name=Input::get('name');
            $user->email=Input::get('email');
            $user->usertype=Input::get('usertype');
            if(Input::get('password')){
                $hashed = Hash::make(Input::get('password'));
                $user->password= $hashed;
                // $user->password=Input::get('email')
            }
             if($request->hasFile('avatar')){
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
                $user->avatar = $filename;
            }
            $user->save();

            $request->session()->flash('alert-success', 'User was updated successfully!');
  return redirect()->action('ClientController@index');

        }
        # code...
    }



    public function destroy($id)
    {
        $user=Clients::find($id);
        if($user){
            $user->delete();
           $msg ='Client member deleted successfully';
           $type='success';
        }
        else{
            $msg ='Sorry, Client can not be found';
            $type='warning';
        }
        return redirect()->action('ClientController@index')
                        ->with($type,$msg);
    }
}
