<?php

namespace App\Listeners;

use App\Events\ContactUpdated;
use App\Services\KlaviyoClient;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUpdatedListener
{
    public function __construct(KlaviyoClient $client)
    {
        $this->client = $client;
    }

    /**
     * Handle the event.
     *
     * @param  ContactUpdated  $event
     * @return void
     */
    public function handle(ContactUpdated $event)
    {
        $this->client->ContactService->updateContact($event->contact);
    }
}
