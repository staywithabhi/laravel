<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Auth;
use Hash;
use Image;
use Validator;
use DB;
use App\User;

class UserController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }
    public function profile(){
        return view('profile',array('user'=>Auth::user()));
    }
    public function home(){

        $clients= DB::connection('mysql2')->table('clients')->get()->count();
        $staff= new User;
        return view('vendor.adminlte.home')->with(compact('clients','staff'));
    }
    public function update_profile(Request $request)
    {
        $user = Auth::user();
        if($request->input('new_password')){
        $rules=array(
            'password' => 'required|min:12',
            'new_password' => 'min:12',
            'new_password_confirmation' => 'required_with:new_password|same:new_password',
            );
            $validator=Validator::make(Input::all(),$rules);
            if($validator->fails()){
                return redirect('profile')->withErrors($validator)->withInput();
            }
        }
        $this->validate($request, ['name'=>'required']);
        if (Hash::check($request->password, $user->password)) 
        { 
            if($request->input('new_password')){
                // $user->fill(['password' => Hash::make($request->newPassword)]);
                $hashed = Hash::make($request->input('new_password'));
                $user->password= $hashed;
            }
            
            if($request->hasFile('avatar')){
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
                $user->avatar = $filename;
            }
            if($request->input('name'))
            {
                $name = $request->input('name');
                $user->name= $name;
            }
            $user->save();
           $request->session()->flash('success', 'Details Updated Successfully');
        //    return view('profile', array('user' => Auth::user()) );
            return redirect()->action('UserController@profile');
        } else 
        {
            $request->session()->flash('error', 'User password is wrong,Please enter correct password');
            // return view('profile', array('user' => Auth::user()) );
            return redirect()->action('UserController@profile');
        }
    
    }
}
