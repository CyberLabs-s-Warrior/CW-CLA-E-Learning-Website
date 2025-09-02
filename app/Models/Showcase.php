<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showcase extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'image_path'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
