<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('settings.edit') ?? true;
    }

    public function rules(): array
    {
        return [
            'session'       => ['nullable', 'string', 'max:255'],
            'header'        => ['nullable', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'favicon'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,ico,webp', 'max:2048'],
            'icon'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'matches_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
        ];
    }
}
