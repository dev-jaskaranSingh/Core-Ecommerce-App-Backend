<?php

namespace Modules\SuperAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendors extends Model
{
    use HasFactory;
    protected $table = "vendors";
    protected $fillable = ['business_category_id', 'delivery_status', 'business_address', 'business_name', 'email', 'name', 'mobile', 'employee_id', 'status', 'lead_status'];
    public static $leadStatus = [
        null => 'Pending',
        1 => 'Converted',
        2 => 'Drop'
    ];
    
    protected static function newFactory()
    {
        return \Modules\SuperAdmin\Database\factories\VendorsFactory::new();
    }

    public function app_details()
    {
        return $this->hasOne(AppDetail::class, 'vendor_id', 'id');
    }
}
