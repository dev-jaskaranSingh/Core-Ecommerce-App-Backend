<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vendors\Database\factories\OrderFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return OrderFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id ', 'id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class,'order_id','id');
    }
}
