<?php

namespace App\Listeners;

use App\Events\ContactChunkImportProcessed;
use App\Services\ContactImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ContactChunkImportListener
{
    /**
     * Handle the event.
     *
     * @param  ContactChunkImportProcessed  $event
     * @return void
     */
    public function handle(ContactChunkImportProcessed $event)
    {
        (new ContactImportService())->checkImport($event->chunk->importdata);
    }
}
