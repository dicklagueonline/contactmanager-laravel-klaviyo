<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactImportData;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImportResource;
use App\Services\ContactImportService;
use App\Events\ContactImportFileDataLoaded;
use App\Http\Requests\ContactImportRequest;
use App\Http\Requests\ContactImportMapRequest;

class ImportContactController extends Controller
{
    public function loadFile(ContactImportRequest $request)
    {
        $file = $request->file('csv');

        $import_file_data = (new ContactImportService())->loadFile($file);

        return new ImportResource($import_file_data);
    }

    public function mapColumn(ContactImportMapRequest $request, ContactImportData $importdata)
    {
        $map = $request->only(['firstname', 'email', 'phone']);

        if (!$importdata) {
            abort(404);
        }

        $importdata->field_maps = json_encode($map);
        $importdata->save();

        return new ImportResource($importdata);
    }

    public function processImport(ContactImportData $importdata)
    {
        if (!$importdata) {
            abort(404);
        }

        event(new ContactImportFileDataLoaded($importdata));

        return new ImportResource($importdata);
    }


    public function cancelImport(ContactImportData $importdata)
    {
        if( !$importdata ) {
            abort(404);
        }

        $importdata->delete();

        return response()->json([
            'status' => true,
            'message' => 'Import contact has been cancelled.'
        ], 200);
    }
}
