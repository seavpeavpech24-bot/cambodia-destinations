<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'category_id',
        'description',
        'location',
        'map_link',
        'best_time_to_visit',
        'entry_fee',
        'cover_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(DestinationCategory::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function travelTips()
    {
        return $this->hasMany(TravelTip::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }
}
