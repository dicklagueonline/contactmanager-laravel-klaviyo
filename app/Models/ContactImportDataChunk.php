<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactImportDataChunk extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_import_data_chunks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_import_data_id', 'chunk_data', 'is_finished', 'saved', 'unsaved', 'processed'
    ];

    public function importdata() {
        return $this->belongsTo('App\Models\ContactImportData', 'contact_import_data_id', 'id');
    }
}
