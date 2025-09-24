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


        // social links
        'social_facebook',
        'social_instagram',
        'social_tiktok',
        'social_x',
    ];
}
