<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MapCoordinator extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'map_coordinators';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'destination_id',
        'description',
        'type',
        'icon_class',
        'latitude_and_longitude',
        'map_link',
        'cover_url'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Available type options
     */
    const TYPE_OPTIONS = [
        'Temples' => 'Temples',
        'Natural Sites' => 'Natural Sites',
        'Accommodations' => 'Accommodations',
        'Local Dishes' => 'Local Dishes',
        'Historical Sites' => 'Historical Sites'
    ];

    /**
     * Get the destination that owns the map coordinator.
     */
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
} 