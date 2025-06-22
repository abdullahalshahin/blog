<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model {
    use HasFactory;

    protected $guarded = [];

    public function metaable() {
        return $this->morphTo();
    }
}
