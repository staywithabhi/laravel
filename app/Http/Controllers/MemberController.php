<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Input;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use App\User;
use App\Role;
use App\Clients;
use App\Members;
use DB;
use Hash;
use Validator;
use Image;

class MemberController extends Controller
{
        // const API_URL = 'http://clientportal.local/api/';
    // const API_TOKEN='BCC7vT2DdskjG9kwvfGCkICdz1Y0Ea0BADsjePXdkaiO0hV67z09iVJ5nEJL';
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($id,Request $request,Builder $htmlbuilder)
    {

	 	 $user=Clients::find($id);
        if(!$user){
  		$clients= DB::connection('mysql2')->table('clients')->get();
  		$request->session()->flash('alert-danger', 'Requested Client can not be found');
        // return redirect()->action('ClientController@index')->with(compact('clients');
  		return redirect()->action('ClientController@index')->with('clients',$clients);
        }

        if($request->ajax())
        {
            // $staff=DB::table('users  ')->select(['id','name','email','usertype','avatar']);
             $clients=DB::connection('mysql2')->table('users')->select(['id','name','email','avatar'])->where('client_id',$id);
            return Datatables::of($clients)
            ->addColumn('action', function($row) {
                return '<a href="/memberEdit/'. $row->id .'" class="btn btn-primary">Edit</a>
                <a data-href="/memberDelete/'. $row->id .'" class="btn btn-danger" title="Delete" data-toggle="modal" data-target="#confirm-delete">Delete</a>';
            })
            ->make(true);
        }
        $html= $htmlbuilder
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
        return view('clients.members')->with(compact('html','id'));
    

    }

    public function addMemberToClient($id)
    {
        return view('clients.addMemberToClient')->with(compact('id',$id));
    }

    public function saveMemberToClient(Request $request)
    {
    	// echo "abhishek";
    	// exit;
        $member= new Members;
       
        try {
 
        if($request->input('name'))
        {
            $name = $request->input('name');
            $member->name= $name;
        }
        if($request->input('email'))
        {
            $email = $request->input('email');
            $member->email= $email;
        }

        if($request->input('client_id'))
        {
            $client_id = $request->input('client_id');
            $member->client_id= $client_id;
        }
        if($request->input('password')){
            $hashed = Hash::make($request->input('password'));
            $member->password= $hashed;
            }
        if($request->input('remember_token'))
        {
            $remember_token = $request->input('remember_token');
            $member->remember_token= $remember_token;
        }
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            // echo "<pre>";
            // print_r($avatar->getClientOriginalExtension());
            // exit;
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
    		Image::make($avatar)->resize(300, 300,function($constraint)
            {
                $constraint->aspectRatio();
            })->save( public_path('/uploads/avatars/' . $filename ) );
            // echo public_path('/uploads/avatars/' . $filename );
            // exit;
            $client = new GuzzleHttpClient();
            $clientRequest = $client
            ->post('http://clientportal.local/api/uploadImage',
            [
                'multipart' => [
                    [
                        'name'     =>  'avatar',
                        'contents' => fopen(public_path('/uploads/avatars/' . $filename ), 'r')
                    ],
                   
                ]
            ]);
            $clients = json_decode($clientRequest->getBody()->getContents());
        //   echo "abhgfdishek<pre>";
        //   print_r($clients);
        //   exit;
            $member->avatar = $filename;

        }
        
        $member->save();
        $request->session()->flash('alert-success', 'Member was added successfully!');

    }
    catch(\Illuminate\Database\QueryException $e){
        // echo "<pre>";
        // print_r($e->errorInfo);
        // exit;

        $errorCode = $e->errorInfo[1];
        if($errorCode == '1062'){
            $request->session()->flash('alert-danger', 'Another record with same email already exists');

        }
    }
        // return redirect()->action('MemberController@index')->with('');
        return redirect()->route('manage', ['id' =>$client_id]);
        // {{ route('manage', ['id' => $client->id]) }}
    }

    public function edit($id)
    {
        $member=Members::find($id);
      
        if($member){

            return view('clients.editmember')->with('member',$member);  
        }
        else{
         
            $msg ='Sorry, Member can not be found';
            $type='warning';
   return redirect()->back()->with($type,$msg);
        }
    }

     public function update($id,Request $request)
    {
        // echo "abhios";
        // exit;
        $rules=array(
        'name' => 'required|max:255',
        'email' => 'required|email|max:255',
        
        // 'password' => 'required|min:6|confirmed',
        // 'accept_terms' => 'required|accepted',
        );
        $validator=Validator::make(Input::all(),$rules);
        $this->validate($request, ['name'=>'required']);
        if($validator->fails()){
            return redirect('memberEdit/'.$id)->withErrors($validator)->withInput();
        }
        else{

            $member=Members::find($id);
            $member->name=Input::get('name');
            $member->email=Input::get('email');
         	 if($request->input('client_id'))
		    {
	            $client_id = $request->input('client_id');
	            $member->client_id= $client_id;
      		  }
            if(Input::get('password')){
                $hashed = Hash::make(Input::get('password'));
                $member->password= $hashed;
                // $user->password=Input::get('email')
            }
             if($request->hasFile('avatar')){
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
                $member->avatar = $filename;
            }

            $member->save();
            
            // $user->roles()->attach($role_user);

            $request->session()->flash('alert-success', 'User was updated successfully!');
 return redirect()->route('manage', ['id' =>$client_id]);

        }
        # code...
    }



    public function destroy($id)
    {
        $member=Members::find($id);
        if($member){
            $member->delete();
           $msg ='Member deleted successfully';
           $type='success';
        }
        else{
            $msg ='Sorry, Member can not be found';
            $type='warning';
        }
        // return redirect()->action('MemberController@index')
        //                 ->with($type,$msg);
     // return   Redirect::back();
        return redirect()->back()->with($type,$msg);

    }
}
