<?php

namespace App\Listeners;

use App\Events\ContactCreated;
use App\Services\KlaviyoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ContactCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  ContactCreated  $event
     * @return void
     */
    public function handle(ContactCreated $event)
    {
        (new KlaviyoService())->ContactService->createContact($event->contact->user, $event->contact);
    }
}
