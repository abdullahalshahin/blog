<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {
    use HasFactory;

    protected $guarded = [];

    static $status = [
        "Draft", "Published", "Archived"
    ];

    public function seo_meta() {
        return $this->morphOne(SeoMeta::class, 'metaable');
    }

    public function author() {
        return $this->morphTo();
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'post_categories', 'post_id', 'category_id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function contents() {
        return $this->hasMany(PostContent::class, 'post_id', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function views() {
        return $this->hasMany(PostView::class, 'post_id', 'id');
    }
}
