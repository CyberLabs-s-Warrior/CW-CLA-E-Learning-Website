<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','slug','description','sort_order','is_private',
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Persiapan relasi ke Thread (akan dibuat di Bagian 2)
    public function threads() {
        return $this->hasMany(ForumThread::class, 'category_id');
    }
}
