<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'status',
        'role_name',
        'password',
        'last_name',
        'user_type',
        'is_delete',
        'first_name',
        'fcm_token',
        'device_type',
        'avtar_image',
        'is_approved',
        'profile_image',
        'designation',
        'biography',
        'referral_code',
        'country_id',
        'remember_token',
        'admin_commission',
        'email_verified_at',
        'theme_id',
        'skill',
        'otp',
        'device_id',
        'age',
        'height',
        'height_value_type',
        'weight',
        'weight_value_type',
        'avtar_json',
        'tag_id',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
