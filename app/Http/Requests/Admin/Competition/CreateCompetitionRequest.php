<?php

namespace App\Http\Requests\Admin\Competition;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompetitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->has('created_by_user_id')) {
            $this->merge([
                'created_by_user_id' => auth('admin')->id() ?? auth()->id(),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:competitions,name',
            ],

            'description' => [
                'required',
                'string',
            ],

            'season' => [
                'required',
                'string',
                'max:50',
            ],

            'status' => [
                'required',
                'string',
                'in:draft,upcoming,ongoing,completed,cancelled',
            ],

            'start_date' => [
                'required',
                'date',
                'after:today',
            ],

            'end_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if ($this->start_date && \Carbon\Carbon::parse($value)->lt(\Carbon\Carbon::parse($this->start_date)->addWeek())) {
                        $fail('The end date must be at least 1 week (7 days) after the start date.');
                    }
                },
            ],

            'created_by_user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.after' => 'The start date must be a date after today (starting from tomorrow or later).',
            'end_date.after_or_equal' => 'The end date must be at least 1 week after the start date.',
        ];
    }
}
