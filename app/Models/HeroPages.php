<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeroPages extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hero_pages';

    protected $fillable = [
        'id',
        'title',
        'description',
        'image_url',
        'page',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
