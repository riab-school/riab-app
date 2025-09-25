<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsHealth extends Model
{
    use HasFactory, Uuid;

    protected $fillable = ['user_id', 'blood', 'food_alergic', 'drug_alergic', 'other_alergic', 'disease_history', 'disease_ongoing', 'drug_consumption', 'weight', 'height', 'is_completed'];
}
