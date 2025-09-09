<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class InstructorProfile extends Model
{
    protected $fillable = [
        'user_id','primary_skill','short_bio','github_url','linkedin_url',
        'sort_order','is_published','avatar_path',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}