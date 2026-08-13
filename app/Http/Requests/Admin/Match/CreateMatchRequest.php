<?php

namespace App\Http\Requests\Admin\Match;

use Illuminate\Foundation\Http\FormRequest;

class CreateMatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'competition_id' => 'required|exists:competitions,id',
            'group_id' => 'nullable|exists:competition_groups,id',
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'scheduled_at' => 'required|date',
            'round_number' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ];
    }
}
