<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class YardSale extends Model
{
    use HasFactory, UUID;
    protected $fillable =[
        'user_id',
        'yard_sale_title',
        'yard_sale_date',
        'start_time',
        'end_time',
        'category',
        'description',
        'image_uploads',
        'street',
        'city',
        'state',
        'country',
        'postcode'
    ];
}
