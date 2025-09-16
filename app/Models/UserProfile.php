<?php
// app/Models/UserProfile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserProfile extends Model
{
    protected $fillable = ['user_id','jenis_kelamin','foto','status','tgl_lahir'];
    protected $casts = ['tgl_lahir' => 'date'];
    protected $appends = ['avatar_url']; // <= tambahkan

    public function user() { return $this->belongsTo(User::class); }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->foto) {
            return Storage::url($this->foto);
        }
        $name = $this->user?->name ?? 'User';
        return 'https://ui-avatars.com/api/?rounded=true&name='.urlencode($name);
    }
}
