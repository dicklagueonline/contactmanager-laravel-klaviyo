<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'name' => $this->firstname,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => Carbon::createFromDate($this->created_at)->timestamp,
            'updated_at' => Carbon::createFromDate($this->updated_at)->timestamp,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'status' => true,
            'code' => 200
        ];
    }
}
