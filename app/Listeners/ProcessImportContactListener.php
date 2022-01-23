<?php

namespace App\Listeners;

use App\Services\ContactImportService;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ContactImportFileDataLoaded;
use App\Jobs\ContactImportJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessImportContactListener
{
    /**
     * Handle the event.
     *
     * @param  ContactImportFileDataLoaded  $event
     * @return void
     */
    public function handle(ContactImportFileDataLoaded $event)
    {
        // trigger job queue (dispatch)
        $chunks = $event->importdata->chunks;

        foreach ($chunks as $chunk) {
            ContactImportJob::dispatch($chunk);
        }
    }
}
