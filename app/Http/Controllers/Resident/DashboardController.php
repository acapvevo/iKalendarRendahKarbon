<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:resident.verification.notice');
    }


    public function index(){
        return view('resident.dashboard');
    }
}
