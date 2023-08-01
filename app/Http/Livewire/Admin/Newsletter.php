<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Newsletter as NewsletterModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Newsletter extends Component
{
    use LivewireAlert, WithFileUploads;

    public $newsletters;
    public NewsletterModel $newsletter;

    public $newsletter_id;

    public $thumbnail;
    public $thumbnail_label;

    protected function getListeners()
    {
        return [
            'close' => 'closeModal'
        ];
    }

    protected function rules()
    {
        return [
            'thumbnail' => [
                Rule::requiredIf(fn () => !$this->newsletter->thumbnail),
                'image',
                'max:2048'
            ],
            'newsletter.title' => 'required|string|max:255',
            'newsletter.location' => 'required|string|max:255',
            'newsletter.content' => 'required|string',
            'newsletter.category' => 'required|string|exists:newsletter_category,code'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($newsletters)
    {
        $this->fill([
            'newsletters' => $newsletters,
            'newsletter' => $this->getNewsletterProperty(),
            'thumbnail_label' => __('Insert Newsletter Thumbnail'),
        ]);
    }

    public function getNewsletterProperty()
    {
        return NewsletterModel::find($this->newsletter_id) ?? new NewsletterModel([
            'admin_id' => Auth::guard('admin')->user()->id
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
        $this->reset('thumbnail');
    }

    public function changePlaceholder()
    {
        $file = $this->thumbnail;
        $this->thumbnail_label = $file ? $file->getClientOriginalName()  : __('Insert Newsletter Thumbnail');
    }

    public function create()
    {
        $this->validate();

        $this->saveThumbnail();
        $this->newsletter->admin_id = request()->user('admin')->id;
        $this->newsletter->save();

        return redirect(route('admin.newsletter.list'))->with('success', __("alerts.newsletter_create", ['title' => $this->newsletter->title]));
    }

    public function update()
    {
        $this->validate();

        if ($this->thumbnail) {
            $this->saveThumbnail();
        }

        $this->newsletter->save();

        return redirect(route('admin.newsletter.list'))->with('success', __("alerts.newsletter_update", ['title' => $this->newsletter->title]));
    }

    public function saveThumbnail()
    {
        $thumbnail_name = $this->newsletter->formatTitleForFileName() . '.' . $this->thumbnail->getClientOriginalExtension();
        $thumbnail_path = 'app/newsletter';

        $img = Image::make($this->thumbnail);
        if (!Storage::exists("newsletter")) {
            Storage::makeDirectory("newsletter"); //creates directory
        }
        $img->fit(300, 200)->save(storage_path($thumbnail_path . "/" . $thumbnail_name));

        $this->newsletter->thumbnail = $thumbnail_name;
    }

    public function render()
    {
        $this->changePlaceholder();

        return view('livewire.admin.newsletter');
    }
}
