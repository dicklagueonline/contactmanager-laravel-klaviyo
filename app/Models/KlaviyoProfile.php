<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KlaviyoProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'klaviyo_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'contact_id', 'person_id', 'contact_list_id'
    ];

    public function user() {
        return $this->belongsTo('App\Models\Users');
    }

    public function contact() {
        return $this->belongsTo('App\Models\Contacts');
    }
}
