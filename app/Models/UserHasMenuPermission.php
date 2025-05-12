<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasMenuPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_children_id',
        'assigned_at',
        'is_permanent_access',
        'permited_start_at',
        'permited_end_at'
    ];

    public function childMenuDetail()
    {
        return $this->belongsTo(MasterMenuChildren::class, 'menu_children_id', 'id');
    }

    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
