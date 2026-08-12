<?php

namespace App\Http\Requests\Admin\CompetitionGroup;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompetitionGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $groupId = $this->route('id');

        return [
            'competition_id' => ['sometimes', 'required', 'integer', 'exists:competitions,id'],
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('competition_groups', 'name')->ignore($groupId),
            ],
        ];
    }
}
