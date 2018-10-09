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
use App\Clients;
use App\Members;
use App\User;
use App\Role;
use DB;
use Hash;
use Validator;
use Image;

class ClientController extends Controller
{
    // const API_URL = 'http://clientportal.local/api/';
    // const API_TOKEN='BCC7vT2DdskjG9kwvfGCkICdz1Y0Ea0BADsjePXdkaiO0hV67z09iVJ5nEJL';

    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request,Builder $htmlbuilder)
    {
        // $clients= DB::connection('mysql2')->table('clients')->get();
        // $members= new Members;
        // echo "abhioshek";
        // exit;
        
      if($request->ajax())
      {
          $data='NULL';
           $clients=DB::connection('mysql2')->table('clients')->select(['id','title','active']);
          return Datatables::of($clients)
          ->addColumn('action', function($row) {
              return '<a href="/client/edit/'. $row->id .'" class="btn btn-primary">Edit</a>
              <a data-href="/client/delete/'. $row->id .'" class="btn btn-danger" title="Delete" data-toggle="modal" data-target="#confirm-delete">Delete</a>
              <a href="/members/manage/'. $row->id .'" class="btn btn-success">Manage Members</a>';
          })
          ->addColumn('status', function($row) {
            return $row->active ? "Enabled" : "Disabled" ;
        })
        ->rawColumns(['action', 'status'])
          ->make(true);
      }
      $html= $htmlbuilder
    //   ->addColumn(['data'=>'id','name'=>'id','title'=>'Id'])
      ->addColumn(['data'=>'title','name'=>'title','title'=>'Company Name'])
      ->addColumn([
        'defaultContent' => '',
        'data'           => 'status',
        'name'           => 'status',
        'title'          => 'Status',
        'render'         => null,
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
    

    // echo "<pre>";
    // print_r($html);
    // exit;

      return view('clients.client')->with(compact('html'));
  

  }

    public function addNewClient()
    {
        return view('clients.addclient');
    }

    public function save(Request $request)
    {
        $client= new Clients;
         // $client->setConnection('mysql2');
    
       
        try {
 
        if($request->input('title'))
        {
            $title = $request->input('title');
            $client->title= $title;
        }
        if($request->input('active'))
        {
            $status = $request->input('active');
            $client->active= $status;
        }
        // if($request->input('email'))
        // {
        //     $email = $request->input('email');
        //     $client->email= $email;
        // }
        
        // echo "abhishekdd <pre>";
        // print_r($user);
        // exit;

        $client->save();
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
        // $id=$request->input('id');
        $client=Clients::find($id);
        if($client)
        {
            return view('clients.editclient')->with('client',$client);  
        }
        else
        {
            $msg ='Sorry, Client can not be found';
            $type='warning';
            return redirect()->action('ClientController@index')->with($type,$msg);
        }
    }

     public function update($id,Request $request)
    {
        $rules=array(
        'title' => 'required|max:255',
         'active' => 'required',
        );
        $validator=Validator::make(Input::all(),$rules);
        $this->validate($request, ['title'=>'required']);
        if($validator->fails()){
            return redirect()->action('ClientController@index')->withErrors($validator)->withInput();
        }
        else{
			if($id){

				$client=Clients::find($id);
				$client->title=$request->input('title');
	            $client->active=$request->input('active');
	            $client->save();
            }
            $request->session()->flash('alert-success', 'User was updated successfully!');
            return redirect()->action('ClientController@index');

        }
        # code...
    }

    public function destroy($id)
    {
        $client=Clients::find($id);
        if($client){
            $client->delete();
           $msg ='Client  deleted successfully';
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
