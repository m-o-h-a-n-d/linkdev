<?php

namespace App\Http\Requests\Admin\Match;

use App\Models\GameMatch;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'scheduled_at' => 'required|date',
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0',
            'status' => 'required|in:scheduled,live,finished,postponed,cancelled',
            'notes' => 'nullable|string|max:255',
            'winner_team_id' => 'nullable|exists:teams,id',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $matchId = $this->route('match');
            $match = GameMatch::find($matchId);

            if ($match && $match->group_id === null && $this->status === 'finished') {
                if ((int) $this->home_score === (int) $this->away_score && empty($this->winner_team_id)) {
                    $validator->errors()->add(
                        'winner_team_id',
                        'مباريات الأدوار الإقصائية لا يمكن أن تنتهي بالتعادل. يرجى تحديد الفريق الفائز (بركلات الترجيح / الأشواط الإضافية).'
                    );
                }
            }
        });
    }
}
