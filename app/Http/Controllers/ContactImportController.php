<?php

namespace App\Http\Controllers;

use App\Models\ContactImportData;
use App\Services\ContactImportService;
use App\Events\ContactImportFileDataLoaded;
use App\Http\Requests\ContactImportRequest;
use App\Http\Requests\ContactImportMapRequest;

class ContactImportController extends Controller
{
    public function index()
    {
        return view('contact.import');
    }

    public function loadFile(ContactImportRequest $request)
    {
        $file = $request->file('csv');

        $import_file_data = (new ContactImportService())->loadFile($file);

        return redirect()->route('contact.import.map', $import_file_data);
    }

    public function mapImportFields(ContactImportData $import_file_data)
    {
        $contact_fields = [
            'firstname' => 'First name',
            'email' => 'Email',
            'phone' => 'Phone'
        ];

        $import_column_headers = json_decode($import_file_data->column_headers, true);

        return view('contact.importmapping', compact('import_file_data', 'import_column_headers', 'contact_fields'));
    }

    public function processImport(ContactImportMapRequest $request)
    {
        $import_file_data_id = $request->input('import_file_data_id');

        $map = $request->only(['firstname', 'email', 'phone']);

        $import_file_data = ContactImportData::find($import_file_data_id);
        $import_file_data->field_maps = json_encode($map);
        $import_file_data->save();

        event(new ContactImportFileDataLoaded($import_file_data));

        return redirect()->route('contact.index')->with('success', 'Importing contacts from file is being process.');
    }
}
