<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsbPaymentHistory extends Model
{
    use Uuid;

    protected $fillable = [
        'user_id', 'psb_config_id', 'payment_method', 'evidence', 'transaction_id', 'amount', 'request_at', 'qris_content', 'qris_invoiceid', 'qris_nmid', 'manual_bank_from', 'manual_invoiceid', 'payment_status', 'status'
    ];

    public function psbConfig()
    {
        return $this->belongsTo(PsbConfig::class, 'psb_config_id');
    }

    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
