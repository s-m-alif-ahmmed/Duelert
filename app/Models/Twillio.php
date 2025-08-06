<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Twillio extends Model
{
    use HasFactory;

    protected $fillable = [
        'twilio_sid',
        'twilio_auth_token',
        'twilio_from',
    ];
}
