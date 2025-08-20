<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
    'user_id',
    'jenis_kelamin',
    'foto',
    'status',
    'tgl_lahir',
];
    protected $casts = [
        'tgl_lahir' => 'date',
    ];


   public function user()
{
    return $this->belongsTo(User::class);
}

}
