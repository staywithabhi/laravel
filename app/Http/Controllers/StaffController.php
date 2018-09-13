<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class StaffController extends Controller
{
    //
    public function index()
    {
        // echo "hello";exit;
        $staff=DB::table('users')->get();
        
        return view('staff',compact('staff'));
    }
}
