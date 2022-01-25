<?php

namespace App\Listeners;

use App\Events\ContactDeleted;
use App\Services\KlaviyoClient;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactDeletedListener
{
    public function __construct(KlaviyoClient $client)
    {
        $this->client = $client;
    }

    /**
     * Handle the event.
     *
     * @param  ContactDeleted  $event
     * @return void
     */
    public function handle(ContactDeleted $event)
    {
        $this->client->ContactService->deleteContact($event->contact);
    }
}
