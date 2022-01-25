<?php

namespace App\Listeners;

use App\Events\ContactCreated;
use App\Services\KlaviyoClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ContactCreatedListener
{
    public function __construct(KlaviyoClient $client)
    {
        $this->client = $client;
    }

    /**
     * Handle the event.
     *
     * @param  ContactCreated  $event
     * @return void
     */
    public function handle(ContactCreated $event)
    {
        $this->client->ContactService->createContact($event->contact->user, $event->contact);
    }
}
