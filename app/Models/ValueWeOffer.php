<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValueWeOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_one',
        'image_two',
    ];

    public function getImageOneAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }
    public function getImageTwoAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }
}
