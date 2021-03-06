<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'firstname', 'email', 'phone'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function klaviyo() {
        return $this->hasOne('App\Models\KlaviyoProfile', 'contact_id', 'id');
    }
}
