<?php

namespace App\Traits;

use App\Models\Newsletter;

trait NewsletterTrait
{
    public function getNewsletters()
    {
        return Newsletter::all()->sortByDesc('created_at');
    }

    public function getNewsletter($id)
    {
        return Newsletter::find($id);
    }
}
