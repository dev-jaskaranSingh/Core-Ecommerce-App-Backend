<?php

namespace Modules\MarketingEmployee\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\MarketingEmployee\Database\factories\MarketingLeadFactory;
class MarketingLead extends Model
{
    use HasFactory;

    protected $fillable = ['business_category_id', 'delivery_status', 'business_address', 'business_name', 'email', 'name', 'mobile', 'employee_id', 'status', 'lead_status'];

    protected static function newFactory()
    {
        return MarketingLeadFactory::new();
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('d-m-Y');
    }
}
