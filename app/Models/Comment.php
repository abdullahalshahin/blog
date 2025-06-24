<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model {
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    static $status = [
        "Pending", "Approved", "Spam"
    ];

    public function getFormattedCreatedAtAttribute() {
        return $this->created_at->format('H:i | F d, Y');
    }

    public function commenter() {
        return $this->morphTo();
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function sub_comments() {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }
}
