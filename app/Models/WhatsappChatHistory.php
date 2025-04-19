<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappChatHistory extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'type',
        'category',
        'media_url',
        'media_mime',
        'name',
        'phone',
        'message',
        'response_id',
        'response_status',
        'response_message',
        'process_status',
        'is_read'
    ];
}
