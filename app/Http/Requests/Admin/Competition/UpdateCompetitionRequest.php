<?php

namespace App\Http\Requests\Admin\Competition;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompetitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $competitionId = $this->route('id');

        return [
            'name' => [
                'nullable',
                'string',
                'max:255',
                'unique:competitions,name,'.$competitionId,
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:competitions,slug,'.$competitionId,
            ],

            'description' => ['nullable', 'string'],

            'season' => ['nullable', 'string', 'max:50'],

            'status' => [
                'nullable',
                'string',
                'in:draft,upcoming,ongoing,completed,cancelled',
            ],

            'start_date' => ['nullable', 'date'],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'winner_team_id' => [
                'nullable',
                'integer',
                'exists:teams,id',
            ],
        ];
    }
}
