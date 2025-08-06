<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurKeyHighlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'body_title',
        'icon',
        'description',
        'status',
    ];

    public function getImageAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }

    public function getIconAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }
}
