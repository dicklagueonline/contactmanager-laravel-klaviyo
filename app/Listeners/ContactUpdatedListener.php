<?php

namespace App\Listeners;

use App\Events\ContactUpdated;
use App\Services\KlaviyoService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUpdatedListener
{
    /**
     * Handle the event.
     *
     * @param  ContactUpdated  $event
     * @return void
     */
    public function handle(ContactUpdated $event)
    {
        info("A contact has been updated: " . $event->contact);
        (new KlaviyoService())->ContactService->updateContact($event->contact);
    }
}
