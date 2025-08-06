<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'phone',
        'email',
        'image',
    ];

    public function getImageAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }
}
