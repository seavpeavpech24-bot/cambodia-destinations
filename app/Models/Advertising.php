<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertising extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'advertising';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'video_url',
        'image_url',
        'link',
        'start_date',
        'expire_date',
        'is_visible'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'expire_date' => 'datetime',
        'is_visible' => 'boolean',
    ];

    /**
     * Set the image URL and clear video URL if set.
     *
     * @param string|null $value
     * @return void
     */
    public function setImageUrlAttribute($value)
    {
        $this->attributes['image_url'] = $value;
        $this->attributes['video_url'] = null;
    }

    /**
     * Set the video URL and clear image URL if set.
     *
     * @param string|null $value
     * @return void
     */
    public function setVideoUrlAttribute($value)
    {
        $this->attributes['video_url'] = $value;
        $this->attributes['image_url'] = null;
    }
} 