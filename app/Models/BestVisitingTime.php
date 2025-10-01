<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BestVisitingTime extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'group_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public const GROUP_BY_OPTIONS = [
        'dry_season' => 'Dry Season (November - April)',
        'green_season' => 'Green Season (May - October)',
    ];
} 