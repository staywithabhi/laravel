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
    const API_URL = 'http://myportal.westgateit.co.uk/api/';
    const API_TOKEN='BCC7vT2DdskjG9kwvfGCkICdz1Y0Ea0BADsjePXdkaiO0hV67z09iVJ5nEJL';

    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request,Builder $htmlbuilder)
    {
        
        $members= new Members;
       
            $client = new GuzzleHttpClient();
            $clientRequest = $client->request('GET', self::API_URL.'getClients?api_token='.self::API_TOKEN);  
            // $memberRequest = $client->request('GET',self::API_URL.'getAllMembers?api_token='.self::API_TOKEN);
            $clients = json_decode($clientRequest->getBody()->getContents());
            // $members = json_decode($memberRequest->getBody()->getContents()); 
            return view('clients.client')->with(compact('clients','members'));  
      
    }

    public function addNewClient()
    {
        return view('clients.addclient');
    }

    // public function save(Request $request)
    // {
    //     $client= new Clients;
    //      // $client->setConnection('mysql2');
    
       
    //     try {
 
    //     if($request->input('title'))
    //     {
    //         $title = $request->input('title');
    //         $client->title= $title;
    //     }
    //     if($request->input('email'))
    //     {
    //         $email = $request->input('email');
    //         $client->email= $email;
    //     }
        
    //     // echo "abhishekdd <pre>";
    //     // print_r($user);
    //     // exit;

    //     $client->save();
    //       $request->session()->flash('alert-success', 'Client was added successfully!');

    // }
    // catch(\Illuminate\Database\QueryException $e){
    //     $errorCode = $e->errorInfo[1];
    //     $request->session()->flash('alert-danger', 'Error Processing Your Request');
    //     if($errorCode == '1062'){
    //         $request->session()->flash('alert-danger', 'Another record with same email already exists');

    //     }
    // }
        
    // }

    public function edit($id)
    {
        $client = new GuzzleHttpClient();
        $clientRequest = $client
        ->post(self::API_URL.'getClientDetails?api_token='.self::API_TOKEN,
        [
            'form_params' => [
                'id' => $id,
            ],
        ]
        
        );  
        $clients = json_decode($clientRequest->getBody()->getContents());

        if($clients){
            

            return view('clients.editclient')->with('client',$clients);  
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
        $rules=array(
        'title' => 'required|max:255',
        'email' => 'required|email|max:255',
        );
        $validator=Validator::make(Input::all(),$rules);
        $this->validate($request, ['title'=>'required']);
        if($validator->fails()){
            return redirect('client/edit/'.$id)->withErrors($validator)->withInput();
        }
        else{

            $client = new GuzzleHttpClient();
            $clientRequest = $client
            ->post(self::API_URL.'updateClientDetails?api_token='.self::API_TOKEN,
            [
                'form_params' => [
                    'id' => $id,
                    'title'=> Input::get('title'),
                    'email'=> Input::get('email')
                ],
            ]
            
            ); 
            $clients = json_decode($clientRequest->getBody()->getContents());
            if($clients)
            {
                $request->session()->flash('alert-success', 'User was updated successfully!');
            }
            else{
                $request->session()->flash('alert-danger', 'There was error process your request!');

            }

  return redirect()->action('ClientController@index');

        }
        # code...
    }

    public function save(Request $request)
    {
        $rules=array(
        'title' => 'required|max:255',
        'email' => 'required|email|max:255',
        );
        $validator=Validator::make(Input::all(),$rules);
        $this->validate($request, ['title'=>'required']);
        if($validator->fails()){
            return redirect('clientAdd')->withErrors($validator)->withInput();
        }
        else{

            $client = new GuzzleHttpClient();
            $clientRequest = $client
            ->post(self::API_URL.'saveNewClient?api_token='.self::API_TOKEN,
            [
                'form_params' => [
                    'title'=> Input::get('title'),
                    'email'=> Input::get('email')
                ],
            ]
            
            ); 
            $clients = json_decode($clientRequest->getBody()->getContents());
            // echo "reponse is".$clients;
            // exit;
            if($clients==1)
            {
                $request->session()->flash('alert-success', 'Client was saved successfully!');
            }
            elseif($clients==2){
                $request->session()->flash('alert-danger', 'Another record with same email already exists');
            }
            else{
                $request->session()->flash('alert-danger', 'There was error process your request!');

            }


        }
        return redirect()->action('ClientController@index');

    }
    public function destroy($id)
    {
        // $client=Clients::find($id);

        $client = new GuzzleHttpClient();
            $clientRequest = $client
            ->post(self::API_URL.'deleteClient?api_token='.self::API_TOKEN,
            [
                'form_params' => [
                    'id'=> $id
                ],
            ]
            
            ); 
            $clients = json_decode($clientRequest->getBody()->getContents());
   
          if($client){
            // $client->delete();
           $msg ='Client deleted successfully';
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
