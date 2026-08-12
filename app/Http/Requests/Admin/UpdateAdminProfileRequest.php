<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = auth('admin')->user() ?? auth()->user();
        $userId = $user?->id;
        $adminProfileId = $user?->admin?->id;

        return [
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password'    => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone'       => ['required', 'string', 'max:20', Rule::unique('admin_profiles', 'phone')->ignore($adminProfileId)],
            'national_id' => ['required', 'numeric', Rule::unique('admin_profiles', 'national_id')->ignore($adminProfileId)],
            'address'     => ['required', 'string', 'max:255'],
            'gender'      => ['required', 'string', 'in:Male,Female'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ];
    }
}
