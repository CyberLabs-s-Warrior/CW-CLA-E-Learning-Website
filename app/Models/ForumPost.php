<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumPost extends Model
{
    use SoftDeletes;

    protected $fillable = ['thread_id','user_id','body'];

    public function thread() { return $this->belongsTo(ForumThread::class, 'thread_id'); }
    public function user()   { return $this->belongsTo(User::class); }
}
