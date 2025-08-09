<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
    'user_id',
    'nama_lengkap',
    'jenis_kelamin',
    'no_hp',
    'alamat',
    'status',
    'tgl_lahir',
    'foto',
];


   public function user()
{
    return $this->belongsTo(User::class);
}

}
