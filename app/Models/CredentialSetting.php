<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CredentialSetting extends Model
{
    use HasFactory;

    public $fillable = [
        'callback_url',
        'paystack_public_key',
        'paystack_secret_key',
    ];

}
