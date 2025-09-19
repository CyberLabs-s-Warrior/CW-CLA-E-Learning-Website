<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumThreadResolution extends Model
{
    protected $fillable = ['thread_id','post_id','marked_by'];

    public function thread() { return $this->belongsTo(ForumThread::class); }
    public function post()   { return $this->belongsTo(ForumPost::class); }
    public function marker() { return $this->belongsTo(User::class, 'marked_by'); }
}
