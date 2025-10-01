<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'destination_id',
    ];

    // Assuming destination_id is a foreign key to destinations table
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
