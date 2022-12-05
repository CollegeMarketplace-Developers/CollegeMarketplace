<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Message extends Model
{
    use HasFactory;
    protected $fillable=['from', 'to', 'for_listing', 'for_rentals', 'message', 'is_read'];
}
