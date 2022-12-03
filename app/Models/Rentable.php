<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentable extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'rental_title',
        'rental_duration', //hourly, daily, weekly, monthly
        'rental_charging', //amount charging per time period
        'negotiable',
        'condition',
        'category',
        'tags',
        'description',
        'image_uploads',
        'street',
        'city',
        'state',
        'country',
        'postcode',
        'status', //either rented or available,

        'created_at',
        'updated_at',

        'apartment_floor',
        'latitude',
        'longitude',
        'view_count'
    ];

    protected $dates = ['created_at', 'updated_at'];

    // this rentable belongs to a certain user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
