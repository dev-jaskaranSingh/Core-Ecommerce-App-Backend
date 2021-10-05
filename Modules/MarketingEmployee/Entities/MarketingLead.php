<?php

namespace Modules\MarketingEmployee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketingLead extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\MarketingEmployee\Database\factories\MarketingLeadFactory::new();
    }
}
