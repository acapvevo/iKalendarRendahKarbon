<?php

namespace App\Http\Requests\Universal\Newsletter;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ViewThumbnailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check() || Auth::guard('community')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'newsletter_id' => 'required|numeric|exists:newsletters,id'
        ];
    }
}
