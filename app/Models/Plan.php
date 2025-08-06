<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'plan_code',
        'price',
        'customers_limit',
        'storage_limit',
        'sms_limit',
        'customize_birth_message',
        'status',
    ];


    public function reviews()
    {
        return $this->hasMany(PlanReview::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}
