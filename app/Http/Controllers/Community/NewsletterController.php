<?php

namespace App\Http\Controllers\Community;

use App\Models\Newsletter;
use App\Traits\NewsletterTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsletterController extends Controller
{
    use NewsletterTrait;

    public function list()
    {
        $newsletters = $this->getNewsletters();

        return view('community.newsletter.list')->with([
            'newsletters' => $newsletters
        ]);
    }

    public function thumbnail(Request $request)
    {
        $request->validate([
            'newsletter_id' => 'required|numeric|exists:newsletters,id'
        ]);

        $newsletter = $this->getNewsletter($request->newsletter_id);

        return $newsletter->previewThumbnail();
    }
}
