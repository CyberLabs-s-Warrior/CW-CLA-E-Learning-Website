<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'email',
        'telepon',
        'alamat',
        'link_maps',
        'url_email',
        'url_telepon',
        'url_alamat',
        'latitude',
        'longitude',

        // legacy (biar mass-assign gak error kalau masih dipakai di form lama)
        'phone_number',
        'location_label',
        'location_url',
    ];
}
