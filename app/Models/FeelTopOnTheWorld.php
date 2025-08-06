<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeelTopOnTheWorld extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'button_text',
        'status',
    ];

    public function getImageAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }
}
