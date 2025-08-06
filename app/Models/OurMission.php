<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurMission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
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
