<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class WatchItem extends Model
{
    use HasFactory, UUID;
    protected $fillable=[
        'user_id',
        'watchitem_title',
        'type',
        'match_rate',
        'key_tags'
    ];
}
