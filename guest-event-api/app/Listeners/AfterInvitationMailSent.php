<?php

namespace App\Listeners;

use App\Models\Guest;
use Illuminate\Container\Attributes\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;

use function Illuminate\Log\log;

class AfterInvitationMailSent implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageSent $event): void
    {

        $mailable = $event->data['guest'] ?? null;

        if ($mailable) {
            $guest = Guest::find($mailable->id);

            if ($guest) {
                $guest->update([
                    'is_invitation_send' => true
                ]);
            }
        }
    }
}
