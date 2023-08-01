<?php

namespace App\Http\Controllers\Community;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsletterController extends Controller
{
    public function list()
    {
        $newsletters = Newsletter::all()->sortByDesc('created_at');

        return view('community.newsletter.list')->with([
            'newsletters' => $newsletters
        ]);
    }
}
