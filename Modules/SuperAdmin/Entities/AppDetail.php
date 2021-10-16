<?php

namespace Modules\SuperAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Vendors;

class AppDetail extends Model
{
    use HasFactory;

    protected $table = "app_details";
    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\SuperAdmin\Database\factories\AppDetailFactory::new();
    }

    public function vendor_details()
    {
        return $this->belongsTo(Vendors::class, 'vendor_id', 'id');
    }
}
