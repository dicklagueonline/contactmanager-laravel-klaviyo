<?php

namespace App\Services;

use App\Models\Contact;
use App\Events\ContactCreated;
use App\Models\ContactImportData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactImportDataChunk;
use App\Events\ContactChunkImportProcessed;

class ContactImportService
{
    public function loadFile($file)
    {
        $path = $file->getRealPath();

        $data = array_map('str_getcsv', file($path));

        $import_column_headers = array_slice($data, 0, 1)[0];

        $import_data = array_slice($data, 1);

        $lines = count($import_data);

        $csv_data_chunks = array_chunk($import_data, 5000, true);

        $import_file_data = ContactImportData::create([
            'user_id' => Auth::user()->id,
            'filename' => $file->getClientOriginalName(),
            'column_headers' => json_encode($import_column_headers),
            'lines' => $lines
        ]);

        foreach ($csv_data_chunks as $chunk) {
            $import_file_data->chunks()->create([
                'chunk_data' => json_encode($chunk)
            ]);
        }

        return $import_file_data;
    }

    public function importRow(ContactImportData $importdata, $row)
    {
        $columns = json_decode($importdata->column_headers, true);

        $maps = json_decode($importdata->field_maps, true);

        $data = [
            'user_id' => $importdata->user->id
        ];

        foreach ($maps as $field => $header) {
            $index = array_search($header, $columns);
            $data[$field] = $row[$index];
        }

        $contact = Contact::updateOrCreate([
            'user_id' => $data['user_id'],
            'firstname' => $data['firstname']
        ], $data);

        // Delay event execution on mass import to delay http request on klaviyo api
        time_nanosleep(0, 1000000);

        event(new ContactCreated($contact));

        return $contact;
    }

    public function importChunk(ContactImportDataChunk $chunk)
    {
        $rows = json_decode($chunk->chunk_data, true);

        $processed = 0;
        $saved = 0;
        $unsaved = 0;

        foreach ($rows as $row) {
            if ($this->importRow($chunk->importdata, $row)) {
                $saved++;
            } else {
                $unsaved++;
            }

            $processed++;
        }

        $this->updateChunkStatus($chunk, compact('processed', 'saved', 'unsaved'));
    }

    public function updateChunkStatus(ContactImportDataChunk $chunk, $counter)
    {
        $chunk->update([
            'is_finished' => true,
            'saved' => (int) $counter['saved'],
            'unsaved' => (int) $counter['unsaved'],
            'processed' => (int) $counter['processed']
        ]);

        event(new ContactChunkImportProcessed($chunk));
    }

    public function checkImport(ContactImportData $importdata)
    {
        $chunks = $importdata->chunks()->where('is_finished', 0)->count();

        if ($chunks === 0) {
            // get import status before deleting the import data
            $status = DB::table('contact_import_data_chunks')
                ->select(
                    'contact_import_data_id',
                    DB::raw('SUM(processed) as total_processed'),
                    DB::raw('SUM(saved) as total_saved'),
                    DB::raw('SUM(unsaved) as total_unsaved')
                )
                ->groupBy('contact_import_data_id')
                ->where('is_finished', true)
                ->where('contact_import_data_id', $importdata->id)
                ->first();

            // delete the import data and all its chunks data
            $importdata->delete();

            // todo: send notification to browser with dat on status
        }
    }
}
