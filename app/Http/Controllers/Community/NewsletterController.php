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

    public function thumbnail(Request $request)
    {
        $request->validate([
            'newsletter_id' => 'required|numeric|exists:newsletters,id'
        ]);

        $newsletter = Newsletter::find($request->newsletter_id);

        return $newsletter->previewThumbnail();
    }
}
