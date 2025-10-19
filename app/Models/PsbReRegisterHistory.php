<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsbReRegisterHistory extends Model
{
    use HasFactory, Uuid;
    
    protected $fillable =
    [
        'user_id',
        'psb_configs_id',
        'paid_verification_file',
        'payment_verified_by',
        'paid_via',
        'paid_amount',
        'is_paid'
    ];
}
