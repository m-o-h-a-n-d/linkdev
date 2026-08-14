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
                function ($attribute, $value, $fail) {
                    $startDate = $this->start_date ?? \App\Models\Competition::find($this->route('id'))?->start_date;
                    if ($startDate && $value && \Carbon\Carbon::parse($value)->lt(\Carbon\Carbon::parse($startDate)->addWeek())) {
                        $fail('The end date must be at least 1 week (7 days) after the start date.');
                    }
                },
            ],

            'winner_team_id' => [
                'nullable',
                'integer',
                'exists:teams,id',
            ],
        ];
    }
}
