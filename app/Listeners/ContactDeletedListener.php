<?php

namespace App\Listeners;

use App\Events\ContactDeleted;
use App\Services\KlaviyoService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactDeletedListener
{
    /**
     * Handle the event.
     *
     * @param  ContactDeleted  $event
     * @return void
     */
    public function handle(ContactDeleted $event)
    {
        info("A contact is has been deleted.");
        (new KlaviyoService())->ContactService->deleteContact($event->contact);
    }
}
