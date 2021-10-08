<?php

namespace Modules\MarketingEmployee\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\MarketingEmployee\Database\factories\MarketingLeadFactory;

class MarketingLead extends Model
{
    use HasFactory;

    protected $fillable = ['business_category_id', 'delivery_status', 'business_address', 'business_name', 'email', 'name', 'mobile', 'employee_id', 'status', 'lead_status'];
    public static $leadStatus = [
        null => 'Pending',
        1 => 'Converted',
        2 => 'Drop'
    ];

    protected static function newFactory()
    {
        return MarketingLeadFactory::new();
    }

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function lead_employee(): BelongsTo
    {
        return $this->belongsTo(MarketingEmployee::class, 'employee_id', 'id');
    }

    public function getDeliveryStatusAttribute($value): string
    {
        return $value == 1 ? 'true' : 'false';
    }
}
