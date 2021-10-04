<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Vendors\Database\factories\OrderItemFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'user_id', 'product_id', 'qty', 'price', 'amount', 'discount_price', 'discount_percentage', 'final_amount', 'status'];

    protected static function newFactory()
    {
        return OrderItemFactory::new();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
