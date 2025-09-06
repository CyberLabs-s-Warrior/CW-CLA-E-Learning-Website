<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder; // <-- tambahkan

class Testimonial extends Model
{
    protected $fillable = ['user_id','content','is_published'];

    // biar checkbox & query boolean mantap
    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // <-- tambahkan scope ini
    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true);
    }
}
