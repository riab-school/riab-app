<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsbDocumentRejection extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'psb_config_id',
        'document_field_key',
        'rejection_reason',
        'reject_by',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function psbConfig()
    {
        return $this->belongsTo(PsbConfig::class);
    }

    public function rejectBy()
    {
        return $this->belongsTo(User::class, 'reject_by');
    }
}
