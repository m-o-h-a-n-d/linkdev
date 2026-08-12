<?php

namespace App\Http\Requests\Viewer;

use Illuminate\Foundation\Http\FormRequest;

class PublicTeamRegistrationRequest extends FormRequest
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
            'country'      => ['required', 'string', 'max:100'],
            'city'         => ['required', 'string', 'max:100'],
            'arena'        => ['nullable', 'string', 'max:255'],
            'manager_name' => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255'],
            'phone'        => ['required', 'string', 'max:50'],
            'logo'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ];
    }
}
