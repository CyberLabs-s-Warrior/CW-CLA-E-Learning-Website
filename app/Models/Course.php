<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_category_id',
        'course_level_id',
        'course_price_range_id',
        'name',
        'slug',
        'price',
        'img',
        'students_count',
        'rating',
    ];

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function level()
    {
        return $this->belongsTo(CourseLevel::class, 'course_level_id');
    }

    public function priceRange()
    {
        return $this->belongsTo(CoursePriceRange::class, 'course_price_range_id');
    }

    // Relasi ke lessons
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    // Relasi ke detail course (1-to-1)
    public function detail()
    {
        return $this->hasOne(CourseDetail::class);
    }

    // Scope untuk gratisan
    public function scopeFree($query)
    {
        return $query->where('price', 0);
    }

    // Scope untuk berbayar
    public function scopePaid($query)
    {
        return $query->where('price', '>', 0);
    }

    public function isFree(): bool
    {
        return $this->price == 0;
    }

    // Relasi ke enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Relasi ke users (student yang daftar course ini)
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withPivot('status', 'payment_id')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function instructors()
    {
        return $this->belongsToMany(User::class, 'course_instructors')
            ->withTimestamps();
    }

    public function getDurationAttribute()
    {
        return $this->lessons()->sum('duration');
    }

    protected static function booted()
    {
        static::saving(function ($course) {
            if ($course->price !== null) {
                $range = CoursePriceRange::where('min_price', '<=', $course->price)
                    ->where('max_price', '>=', $course->price)
                    ->first();

                $course->course_price_range_id = $range?->id;
            }
        });
    }

    public function getFormattedDurationAttribute()
    {
        $seconds = $this->duration;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $remainingSeconds = $seconds % 60;

        if ($hours > 0) {
            return $hours . ' jam' . ($minutes > 0 ? ' ' . $minutes . ' menit' : '');
        } elseif ($minutes > 0) {
            return $minutes . ' menit' . ($remainingSeconds > 0 ? ' ' . $remainingSeconds . ' detik' : '');
        } else {
            return $remainingSeconds . ' detik';
        }
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function progressPercentFor(\App\Models\User $user): int
    {
        $total = $this->lessons()->count();
        if ($total === 0) return 0;

        $done = \App\Models\LessonProgress::where('user_id', $user->id)
            ->where('course_id', $this->id)
            ->count();

        return (int) round(($done / $total) * 100);
    }
    public function nextIncompleteLessonFor(\App\Models\User $user): ?\App\Models\Lesson
    {
        $doneIds = \App\Models\LessonProgress::where('user_id',$user->id)
            ->where('course_id',$this->id)
            ->pluck('lesson_id');

        // urutkan konsisten: module_name lalu order (lihat pola di controller admin)
        return $this->lessons()
            ->orderBy('module_name')
            ->orderBy('order')
            ->whereNotIn('id', $doneIds)
            ->first();
    }
    
}
