<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ForumPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'thread_id',
        'user_id',
        'body',
        'image_path', // 1 gambar per post
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        // butuh php artisan storage:link
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    public function thread()
    {
        return $this->belongsTo(ForumThread::class, 'thread_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
