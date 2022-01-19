<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\ContactImportDataChunk;
use App\Services\ContactImportService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ContactImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chunk;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ContactImportDataChunk $chunk)
    {
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //call import service to save data

        $rows = json_decode($this->chunk->chunk_data, true);

        $processed = 0;

        $saved = 0;

        $unsaved = 0;

        foreach ($rows as $row) {
            if ((new ContactImportService())->importRow($this->chunk->importdata, $row)) {
                $saved++;
            } else {
                $unsaved++;
            }

            $processed++;
        }

        (new ContactImportService())->updateChunkStatus($this->chunk, compact('processed', 'saved', 'unsaved'));
    }
}
