<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\SendOtpNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOtpNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 3;

    public function __construct(
        public User $user,
        public string $otp
    ) {}

    public function handle(): void
    {
        try {
            $this->user->notify(new SendOtpNotify($this->otp));
        } catch (\Throwable $e) {
            Log::error('SendOtpNotificationJob failed for user ' . $this->user->id . ': ' . $e->getMessage());
            throw $e;
        }
    }
}
