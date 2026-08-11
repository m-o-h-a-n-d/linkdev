<?php

namespace App\Http\Requests\Admin\Team;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $teamId = $this->route('team');

        return [
            'name'             => ['required', 'string', 'max:255', Rule::unique('teams', 'name')->ignore($teamId)],
            'short_name'        => ['required', 'string', 'max:20'],
            'city'             => ['required', 'string', 'max:100'],
            'country'          => ['required', 'string', 'max:100'],
            'email'            => ['nullable', 'email', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:50'],
            'manager_name'     => ['nullable', 'string', 'max:255'],
            'arena'            => ['nullable', 'string', 'max:255'],
            'logo'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'status'           => ['nullable', 'string', 'in:pending,accepted,rejected'],
            'rejection_reason' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
