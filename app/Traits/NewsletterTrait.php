<?php

namespace App\Traits;

use App\Models\Newsletter;
use Illuminate\Support\Facades\DB;

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

    public function getNewsletterCategories()
    {
        return DB::table('newsletter_category')->get();
    }

    public function getNewslettersForDashboard()
    {
        return $this->getNewsletterCategories()->mapWithKeys(function($category){
            return [$category->code => Newsletter::where('category', $category->code)->take(3)->get()];
        });
    }
}
