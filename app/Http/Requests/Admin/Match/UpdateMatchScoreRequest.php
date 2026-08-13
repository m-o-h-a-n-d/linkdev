<?php

namespace App\Http\Requests\Admin\Match;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatchScoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'action' => 'required|in:increment_home,decrement_home,increment_away,decrement_away,start_live,finish_match',
        ];
    }
}
