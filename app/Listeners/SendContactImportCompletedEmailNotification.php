<?php

namespace App\Listeners;

use App\Helpers\FormatHelper;
use App\Events\ContactsImportCompleted;
use App\Notifications\ContactsImportEmailNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContactImportCompletedEmailNotification
{
    /**
     * Handle the event.
     *
     * @param  ContactsImportCompleted  $event
     * @return void
     */
    public function handle(ContactsImportCompleted $event)
    {
        $content = [
            'file' => $event->importdata->filename,
            'filesize' => FormatHelper::bytesToSize($event->importdata->file_size),
            'processed_rows' => (int) $event->status->total_processed,
            'finished_at' => $event->importdata->updated_at
        ];

        $event->importdata->user->notify(new ContactsImportEmailNotification($content));
    }
}
