<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumThread extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id','user_id','title','body','is_locked','pinned_at',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'pinned_at' => 'datetime',
    ];

    public function category() { return $this->belongsTo(ForumCategory::class, 'category_id'); }
    public function user()     { return $this->belongsTo(User::class); }

    // Persiapan relasi ke Post (akan dibuat di Bagian 3)
    public function posts()    { return $this->hasMany(ForumPost::class, 'thread_id'); }
    public function bestAnswer() {
    return $this->hasOne(ForumThreadResolution::class, 'thread_id');
}

}
