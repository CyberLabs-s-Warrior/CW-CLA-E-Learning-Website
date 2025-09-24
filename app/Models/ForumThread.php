<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ForumThread extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'body',
        'is_locked',
        'pinned_at',
        'image_path', // 1 gambar per thread
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'pinned_at' => 'datetime',
    ];

    // Biar di-serialize otomatis
    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        // butuh php artisan storage:link
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    // Relasi
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'thread_id');
    }

    public function bestAnswer()
    {
        return $this->hasOne(ForumThreadResolution::class, 'thread_id');
    }
}
