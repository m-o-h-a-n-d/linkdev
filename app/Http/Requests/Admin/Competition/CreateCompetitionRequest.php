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
            ],

            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],

            'created_by_user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
        ];
    }
}
