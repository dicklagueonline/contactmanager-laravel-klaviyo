<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'filename' => $this->filename,
            'filesize' => $this->file_size,
            'filetype' => $this->file_type,
            'extension' => $this->file_extension,
            'headers' => $this->column_headers ? json_decode($this->column_headers, true): [],
            'fields' => $this->fields ? json_decode($this->fields, true): [],
            'mapped_import_fields' => $this->field_maps ? json_decode($this->field_maps, true): [],
            'rows' => $this->lines,
            'created_at' => Carbon::createFromDate($this->created_at)->timestamp,
            'updated_at' => Carbon::createFromDate($this->updated_at)->timestamp,
        ];
    }
}
