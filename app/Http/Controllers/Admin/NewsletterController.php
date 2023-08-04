<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Traits\NewsletterTrait;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    use NewsletterTrait;

    public function list()
    {
        $newsletters = $this->getNewsletters();

        return view('admin.newsletter.list')->with([
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
