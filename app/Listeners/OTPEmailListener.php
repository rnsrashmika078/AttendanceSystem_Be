<?php

namespace App\Listeners;

use App\Events\OTPEmailEvent;
use App\Notifications\SendMailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class OTPEmailListener
{
    /**
     * Create the event listener.
     */
    // public $data;
    // public function __construct($data)
    // {
    //     $this->data = $data;
    // }

    /**
     * Handle the event.
     */
    public function handle(OTPEmailEvent $event): void
    {
        Log::info('Listener Triggered!', [
            'data' => $event->data
        ]);
        Notification::route('mail', $event->data['email'])->notify(new SendMailNotification($event->data));
    }
}
