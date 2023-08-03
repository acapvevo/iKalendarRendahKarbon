<?php

namespace App\Http\Livewire\Community;

use Livewire\Component;
use App\Models\Community;
use App\Traits\Livewire\CheckGuard;
use App\Models\Newsletter as NewsletterModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Newsletter extends Component
{
    use LivewireAlert, CheckGuard;

    protected $guard = 'community';

    public $newsletters;
    public NewsletterModel $newsletter;
    public Community $community;

    public $newsletter_id;

    protected function getListeners()
    {
        return [
            'toggleSubscribe'
        ];
    }

    public function mount($newsletters)
    {
        $this->fill([
            'newsletters' => $newsletters,
            'newsletter' => $this->getNewsletterProperty(),
            'community' => request()->user('community')
        ]);
    }

    public function getNewsletterProperty()
    {
        return NewsletterModel::findOrNew($this->newsletter_id);
    }

    public function toggleSubscribe()
    {
        $this->community->toggleSubscription();

        if ($this->community->isSubscribed)
            $message = __('You have successfully subscribed to our Newsletter');
        else
            $message = __('You have successfully unsubscribed to our Newsletter');

        $this->alert('success', $message, [
            'showConfirmButton' => true,
            'onConfirmed' => null,
            'position' => 'center'
        ]);
    }

    public function open($newsletter_id = null)
    {
        $this->newsletter_id = $newsletter_id;
        $this->newsletter = $this->getNewsletterProperty();

        if ($this->newsletter_id)
            $this->emit('setNewsletterContent', $this->newsletter->content);
    }

    public function close()
    {
        $this->newsletter = new NewsletterModel;
    }

    public function render()
    {
        return view('livewire.community.newsletter');
    }
}
