<?php

namespace App\Http\Requests\Admin\Team;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255', 'unique:teams,name'],
            'short_name'    => ['required', 'string', 'max:20'],
            'city'         => ['required', 'string', 'max:100'],
            'country'      => ['required', 'string', 'max:100'],
            'email'        => ['nullable', 'email', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'manager_name' => ['nullable', 'string', 'max:255'],
            'arena'        => ['nullable', 'string', 'max:255'],
            'logo'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'status'       => ['nullable', 'string', 'in:pending,accepted,rejected'],
        ];
    }
}
