<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalReminderCompanion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
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
}
