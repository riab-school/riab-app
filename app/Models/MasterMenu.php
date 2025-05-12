<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'icon',
        'order',
        'level',
        'is_active'
    ];

    public function children()
    {
        return $this->hasMany(MasterMenuChildren::class, 'menu_id', 'id');
    }
}
