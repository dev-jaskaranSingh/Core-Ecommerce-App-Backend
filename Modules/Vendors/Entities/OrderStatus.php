<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vendors\Database\factories\OrderStatusFactory;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return OrderStatusFactory::new();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class,'order_status_id','id');
    }
}
