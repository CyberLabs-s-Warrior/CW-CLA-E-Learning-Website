<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'detail_courses_id',
        'name',
        'content',
    ];

    // Relasi ke DetailCourse
    public function detailCourse()
    {
        return $this->belongsTo(DetailCourse::class, 'detail_courses_id');
    }
}
