<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tax extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'tax',
        'status',
    ];
}
