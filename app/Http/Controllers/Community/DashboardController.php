<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use Geocoder\Laravel\Facades\Geocoder;

class DashboardController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:community.verification.notice');
    }


    public function index()
    {
        return view('community.dashboard');
    }
}
