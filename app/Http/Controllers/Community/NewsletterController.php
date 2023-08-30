<?php

namespace App\Http\Controllers\Community;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Traits\NewsletterTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Universal\Newsletter\ViewThumbnailRequest;

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

    public function thumbnail(ViewThumbnailRequest $request)
    {
        $validated = $request->validated();

        $newsletter = $this->getNewsletter($validated['newsletter_id']);

        return $newsletter->previewThumbnail();
    }

    public function view($id)
    {
        $newsletter = $this->getNewsletter($id);

        return view('community.newsletter.view')->with([
            'newsletter' => $newsletter
        ]);
    }
}
