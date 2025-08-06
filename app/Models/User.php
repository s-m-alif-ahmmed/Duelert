<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Digikraaft\Paystack\Subscription;
use Digikraaft\PaystackSubscription\Billable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'cover_photo',
        'password',
        'phone',
        'message_limit',
        'position',
        'about',
        'address',
        'country',
        'flag',
        'city',
        'state',
        'zip_code',
        'role',
        'facebook_id',
        'google_id',
        'paystack_customer_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'message_limit',
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
        'password_reset_token',
        'password_reset_token_expiry',
        "google_id",
        "facebook_id",
        "zip_code"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'message_limit' => 'integer'
    ];


    //for api image with url retrieve
    public function getAvatarAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }
    public function getCoverPhotoAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }
    public function getFlagAttribute($value): string | null
    {
        if (request()->is('api/*') && !empty($value)) {
            return url($value);
        }
        return $value;
    }

    /**
     * Get the identifier that will be stored in the JWT subject claim.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get all blogs of the user.
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }


    public function calendars()
    {
        return $this->hasMany(Calendar::class, 'user_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }  
}
