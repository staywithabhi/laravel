<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Input;
use App\Clients;
use App\Members;
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
        
        $clients= DB::table('clients')->get();
        // $members=DB::table('client_members')->get();
        $members= new Members;

        return view('clients.client')->with(compact('clients','members'));

    }

    public function addNewClient()
    {
        return view('clients.addclient');
    }

    public function save(Request $request)
    {
        $client= new Clients;
    
       
        try {
 
        if($request->input('title'))
        {
            $title = $request->input('title');
            $client->title= $title;
        }
        if($request->input('email'))
        {
            $email = $request->input('email');
            $client->email= $email;
        }
        
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
        $client=Clients::find($id);
    //   echo "<pre>";
    //   print_r($user->name);
    //   exit;
        if($client){
            

            return view('clients.editclient')->with('client',$client);  
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
        'title' => 'required|max:255',
        'email' => 'required|email|max:255',
        // 'password' => 'required|min:6|confirmed',
        // 'accept_terms' => 'required|accepted',
        );
        $validator=Validator::make(Input::all(),$rules);
        $this->validate($request, ['title'=>'required']);
        if($validator->fails()){
            return redirect('editClient/'.$id)->withErrors($validator)->withInput();
        }
        else{

            $client=Clients::find($id);
            $client->title=Input::get('title');
            $client->email=Input::get('email');
            $client->save();

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
