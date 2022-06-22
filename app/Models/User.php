<?php

namespace App\Models;

use App\Models\Listing;
use App\Models\Sublease;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password',
        'email',
        'avatar',
        'watchlist',
        'favorites',
        'number',
        'street',
        'city',
        'state',
        'country',
        'postcode'
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
    ];

    public function listings(){
       return $this->hasMany(Listing::class, 'user_id');
    }

    public function rentables(){
       return $this->hasMany(Rentable::class, 'user_id');
    }

    public function subleases(){
       return $this->hasMany(Sublease::class, 'user_id');
    }

}
