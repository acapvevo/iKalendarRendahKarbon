<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Http\Requests\Universal\Newsletter\ViewThumbnailRequest;
use App\Traits\NewsletterTrait;

class DashboardController extends Controller
{
    use NewsletterTrait;

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
