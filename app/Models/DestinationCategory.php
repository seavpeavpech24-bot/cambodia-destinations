<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DestinationCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon_class',
        'title',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function destinations()
    {
        return $this->hasMany(Destination::class, 'category_id');
    }
}
