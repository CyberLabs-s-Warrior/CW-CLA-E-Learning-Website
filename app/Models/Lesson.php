<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'module_name',
        'title',
        'slug',
        'content',
        'media',
        'order',
        'duration',
        'is_preview',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lesson) {
            if (empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title);
            }
        });
    }

    public function getFormattedDurationAttribute()
    {
        $seconds = $this->duration ?? 0;

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $remainingSeconds = $seconds % 60;

        if ($hours > 0) {
            // contoh: 1 jam 40 menit
            return $hours . ' jam ' . ($minutes > 0 ? $minutes . 'menit' : '');
        } elseif ($minutes > 0) {
            // contoh: 40 menit 30 detik
            return $minutes . ' menit ' . ($remainingSeconds > 0 ? $remainingSeconds . 'detik' : '');
        } else {
            // contoh: 40 detik
            return $remainingSeconds . ' detik';
        }
    }
    // app/Models/Lesson.php
    public function progresses(){ return $this->hasMany(LessonProgress::class); }


}