<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Authenticatable {
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    static $genders = [
        "Male", "Female", "Others"
    ];

    static $theme_colors = [
        "light", "dark"
    ];

    static $status = [
        "Active", "Pending", "Suspended"
    ];
}
