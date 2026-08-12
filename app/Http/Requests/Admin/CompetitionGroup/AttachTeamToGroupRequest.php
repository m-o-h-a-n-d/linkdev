<?php

namespace App\Http\Requests\Admin\CompetitionGroup;

use Illuminate\Foundation\Http\FormRequest;

class AttachTeamToGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'team_id' => ['required', 'integer', 'exists:teams,id'],
        ];
    }
}
