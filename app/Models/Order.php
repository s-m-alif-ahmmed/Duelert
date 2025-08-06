<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'valet_id',
        'order_number',
        'payment_method',
        'payment_id',
        'discount',
        'tax',
        'tax_percentage',
        'valet_charge',
        'valet_tip',
        'platform_fee',
        'sub_total',
        'total_price',
        'payment_status',
        'status',
    ];

    // User Relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Shop Relation
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Order Details Relation
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Order Receipts Relation
    public function orderReceipts()
    {
        return $this->hasMany(OrderReceipt::class);
    }
}
