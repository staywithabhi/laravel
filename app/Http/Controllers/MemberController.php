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
// use App\Role;
use App\Roleclient;
use Auth;
use App\Clients;
use App\Members;
use DB;
use Hash;
use Validator;
use Image;

class MemberController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($id,Request $request,Builder $htmlbuilder)
    {

          $user=Clients::find($id);
          $title=$user->title;
        if(!$user){
  		$clients= DB::connection('mysql2')->table('clients')->get();
  		$request->session()->flash('alert-danger', 'Requested Client can not be found');
  		return redirect()->action('ClientController@index')->with('clients',$clients);
        }
        if($request->ajax())
        {
            $data='NULL';
             $clients=DB::connection('mysql2')->table('users')->select(['id','name','email','avatar','usertype'])->where('client_id',$id);
            return Datatables::of($clients)
            ->addColumn('action', function($row) {
                return '<a href="/memberEdit/'. $row->id .'" class="btn btn-primary">Edit</a>
                <a data-href="/memberDelete/'. $row->id .'" class="btn btn-danger" title="Delete" data-toggle="modal" data-target="#confirm-delete">Delete</a>';
            })
            // ->addColumn('roles', function($row) {
            //    if($row->hasRole('manager')){
            //    $data='manager';
            // }
            //     return $data;
            // })
            ->make(true);
        }
        $html= $htmlbuilder
        // ->addColumn(['data'=>'id','name'=>'id','title'=>'Id'])
        ->addColumn(['data'=>'name','name'=>'name','title'=>'Name'])
        ->addColumn(['data'=>'email','name'=>'email','title'=>'Email'])
        ->addColumn(
            ['data'=>trans('usertype'),
            'name'=>'usertype',
            'title'=> trans('User Type')
            ])
        ->addColumn([
            // 'defaultContent' => '',
            'data'=>'avatar',
            'name'=>'avatar',
            'title'=>'Avatar',
            'render' => '"<img src=\"/uploads/avatars/"+data+"\" width=\"50\"/>"',
            'orderable'      => false,
            'searchable'     => false,
            'exportable'     => false,
            'printable'      => true,
            'footer'         => '',
            ]);
    if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('client-readwrite'))
        {
       $html=$html->addColumn([
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
       }
        return view('clients.members')->with(compact('html','id','title'));
    

    }

    public function addMemberToClient($id)
    {
        return view('clients.addMemberToClient')->with(compact('id',$id));
    }

    public function saveMemberToClient(Request $request)
    {
 
        $member= new Members;
       
        try {
            // echo "request params are<pre>";
            // print_r($request->all());
            // exit;
 
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
        if($request->input('usertype'))
        {
            $usertype = $request->input('usertype');
            $member->usertype= $usertype;
        }
        $client = new GuzzleHttpClient();
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
  
            $clientRequest = $client
            //http://myportal.westgateit.co.uk
            ->post('http://myportal.westgateit.co.uk/api/uploadImage',
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
        $roles=$request->input('roles');
        // echo "<pre>";
        // print_r($roles);
        // exit;
        $cid=$member->id;
        if(!empty($roles))
        {

             $clientRequest = $client
            ->post('http://myportal.westgateit.co.uk/api/assignRoles',
            [
                'form_params' => [
                        'id'     =>  $cid,
                        'roles' => $roles    
                   ]
            ]);

            // $member->roles()->detach();
            // foreach($roles as $key=>$value)
            // {
            //     $member->roles()->attach(Roleclient::where('name', $key)->first());
            // }

        }
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
        $client = new GuzzleHttpClient();
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
                if($request->input('usertype'))
                {
                    $usertype = $request->input('usertype');
                    $member->usertype= $usertype;
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
                $clientRequest = $client
                ->post('http://myportal.westgateit.co.uk/api/uploadImage',
                [
                    'multipart' => [
                        [
                            'name'     =>  'avatar',
                            'contents' => fopen(public_path('/uploads/avatars/' . $filename ), 'r')
                        ],
                       
                    ]
                ]);
                $clients = json_decode($clientRequest->getBody()->getContents());
                // echo $clients;
                // exit;
            }

            $member->save();
            $roles=$request->input('roles');
            if(!empty($roles))
            {
                 $clientRequest = $client
                ->post('http://myportal.westgateit.co.uk/api/assignRoles',
                [
                    'form_params' => [
                            'id'     =>  $id,
                            'roles' => $roles           
                       ]
                ]);
    
                // $member->roles()->detach();
                // foreach($roles as $key=>$value)
                // {
                //     $member->roles()->attach(Roleclient::where('name', $key)->first());
                // }
    
            }


            
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
