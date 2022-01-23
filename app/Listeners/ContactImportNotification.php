<?php

namespace App\Listeners;

use App\Helpers\FormatHelper;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactImportNotification
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $notification = [
            'file' => $event->importdata->filename,
            'filesize' => FormatHelper::bytesToSize($event->importdata->filesize),
            'processed_rows' => $event->status['processed'],
            'finished_at' => $event->importdata->updated_at
        ];

        $event->user->notify($notification);
    }
}
