<?php

namespace App\Jobs;

use App\Mail\MatchLiveNotification;
use App\Models\GameMatch;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMatchLiveNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public int $backoff = 3;

    public function __construct(
        public GameMatch $match
    ) {}

    public function handle(): void
    {
        try {
            $emails = User::whereNotNull('email')->pluck('email')->filter()->unique()->toArray();

            if (! empty($emails)) {
                // Send in chunks of 5 with 1-second rate limit delay for Mailtrap / SMTP
                foreach (array_chunk($emails, 5) as $chunkIndex => $chunkEmails) {
                    if ($chunkIndex > 0) {
                        sleep(1);
                    }
                    Mail::bcc($chunkEmails)->send(new MatchLiveNotification($this->match));
                }
            }
        } catch (\Throwable $e) {
            Log::error('SendMatchLiveNotificationJob failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
