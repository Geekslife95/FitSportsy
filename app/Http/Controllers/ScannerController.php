<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ScannerController extends Controller
{
    public function dashboard(){
        // if(Auth::check()){
            return view('scanner/dashboard');
        // }
        return redirect('/scanner/login');
    }
}
