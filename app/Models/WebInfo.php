<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'logo_url',
        'favicon_url',
        'phone_number',
        'email',
        'location',
        'facebook_link',
        'youtube_link',
        'instagram_link',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'phone_number' => 'string',
    ];

    protected $table = 'web_info'; // Specify the table name if it's not the plural of the model name
}
