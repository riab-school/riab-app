<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMenuChildren extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'title',
        'route',
        'order',
        'is_active'
    ];

    public function parent()
    {
        return $this->hasOne(MasterMenu::class, 'id', 'menu_id');
    }

    public function hasAccess()
    {
        return $this->hasMany(UserHasMenuPermission::class, 'menu_children_id', 'id');
    }
}
