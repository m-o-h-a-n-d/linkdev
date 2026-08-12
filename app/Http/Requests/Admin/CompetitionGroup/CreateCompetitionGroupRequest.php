<?php

namespace App\Http\Requests\Admin\CompetitionGroup;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCompetitionGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'competition_id' => ['required', 'integer', 'exists:competitions,id'],
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('competition_groups', 'name'),
            ],
        ];
    }
}
