<?php

namespace App\Console\Commands;

use App\Services\Match\MatchLiveStatusService;
use Illuminate\Console\Command;

class CheckMatchLiveStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:check-live';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update scheduled matches to live status when scheduled time arrives.';

    /**
     * Execute the console command.
     */
    public function handle(MatchLiveStatusService $liveService): int
    {
        $updated = $liveService->checkAndUpdateLiveStatuses();

        $this->info("Updated {$updated->count()} matches to LIVE status.");

        return Command::SUCCESS;
    }
}
