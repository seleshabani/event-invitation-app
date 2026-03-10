<?php

namespace App\Jobs;

use App\Services\GuestService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GuestProcessJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $filename,
        private int $eventId
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(GuestService $service): void
    {
        $service->processGuestFile($this->filename, $this->eventId);
    }
}
