<?php

namespace App\Http\Requests\Admin\Match;

use Illuminate\Foundation\Http\FormRequest;

class GenerateFixturesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'group_id' => 'required|exists:competition_groups,id',
        ];
    }
}
