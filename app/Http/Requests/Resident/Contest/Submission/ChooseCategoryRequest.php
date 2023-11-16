<?php

namespace App\Http\Requests\Resident\Contest\Submission;

use App\Traits\SubmissionTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ChooseCategoryRequest extends FormRequest
{
    use SubmissionTrait;

    /**
     * The route that users should be redirected to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'resident.contest.competition.list';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('resident')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'submission_id' => [
                'required',
                'integer',
                'exists:submissions,id',
                function ($attribute, $value, $fail) {
                    $submission = $this->getSubmission($value);
                    if ($submission->community->resident_id !== request()->user('resident')->id) {
                        $fail(__("You do NOT have right to view this Submission"));
                    }
                }
            ],
            'category' => 'required|string|exists:category,code'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'submission_id' => basename($this->url())
        ]);
    }
}
