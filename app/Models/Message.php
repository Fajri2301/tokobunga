<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'sender_type',
        'message',
        'metadata',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'metadata' => 'array',
    ];
}
