<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactImportData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_import_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'filename', 'file_type', 'file_size', 'file_extension', 'column_headers', 'fields', 'field_maps', 'lines'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function chunks() {
        return $this->hasMany('App\Models\ContactImportDataChunk', 'contact_import_data_id', 'id');
    }
}
