<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reminder extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id', 
        'contact_id',
        'name',
        'email',
        'phone',
        'status',
        'date_of_birth',
        'message',
        'reminder_time',
    ];

    protected $casts = [
        'reminder_time' => 'datetime', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
