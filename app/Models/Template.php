<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'message',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'status'
    ];
    
}
