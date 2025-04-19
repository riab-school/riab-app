<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPermissionHistory extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'requested_by',
        'approved_by',
        'checked_out_by',
        'checked_in_by',
        'rejected_by',
        'reject_reason',
        'token',
        'reason',
        'pickup_by',
        'from_date',
        'to_date',
        'status'
    ];

    public function detail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => '-'
        ]);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => '-'
        ]);
    }

    public function checkedOutBy()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => '-'
        ]);
    }

    public function checkedInBy()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => '-'
        ]);
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => '-'
        ]);
    }
}
