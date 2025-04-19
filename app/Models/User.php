<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'password_changed_at',
        'is_need_to_update_profile',
        'user_level',
        'reset_pass_token',
        'is_allow_act_as',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function menuAccess()
    {
        return $this->hasMany(UserHasMenuPermission::class, 'user_id', 'id');
    }

    public function myDetail()
    {
        if(auth()->user()->user_level == 'admin'){
            return $this->hasOne(AdminDetail::class, 'user_id');
        }

        if(auth()->user()->user_level == 'staff'){
            return $this->hasOne(StaffDetail::class, 'user_id');
        }

        if(auth()->user()->user_level == 'parent'){
            return $this->hasOne(ParentDetail::class, 'user_id');
        }

        if(auth()->user()->user_level == 'student'){
            return $this->hasOne(StudentDetail::class, 'user_id');
        }
    }

    public function adminDetail()
    {
        return $this->hasOne(AdminDetail::class, 'user_id');
    }

    public function staffDetail()
    {
        return $this->hasOne(StaffDetail::class, 'user_id');
    }

    public function parentDetail()
    {
        return $this->hasOne(ParentDetail::class, 'user_id');
    }

    public function studentDetail()
    {
        return $this->hasOne(StudentDetail::class, 'user_id');
    }
}
