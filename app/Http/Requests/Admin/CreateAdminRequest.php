<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
            'phone'       => ['required', 'string', 'max:20', 'unique:admin_profiles,phone'],
            'national_id' => ['required', 'numeric', 'unique:admin_profiles,national_id'],
            'address'     => ['required', 'string', 'max:255'],
            'gender'      => ['required', 'string', 'in:Male,Female'],
            'status'      => ['nullable', 'string', 'in:active,inactive,banned'],
            'role'        => ['nullable', 'string', 'exists:roles,name'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ];
    }
}
