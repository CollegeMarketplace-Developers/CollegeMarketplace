<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sublease extends Model
{
    use HasFactory;
    protected $fillable = [

        'id',
        // sublease owner
        'user_id',

        //sublease attributes
        'sublease_title',
        'location', //ex. shamrock, standard
        'date_from',
        'date_to',
        'rent',
        'negotiable',
        'condition',
        'utilities',
        'description',
        'image_uploads',

        // sublease address
        'street',
        'city',
        'state',
        'country',
        'postcode',
        'status', //either rented or available

        'created_at',
        'updated_at',

        'latitude',
        'longitude',
        'apartment_floor',
        'view_count'
    ];

    // this rentable belongs to a certain user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
