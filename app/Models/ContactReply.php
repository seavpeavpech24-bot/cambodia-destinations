<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_inquiry_id',
        'subject',
        'content',
        'file_path',
        'replied_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function contactInquiry()
    {
        return $this->belongsTo(ContactInquiry::class);
    }
}
