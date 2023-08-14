<?php

namespace App\Http\Requests\Admin\Contest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SelectCompetitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'competition_id' => 'nullable|numeric|exists:competitions,id'
        ];
    }
}
