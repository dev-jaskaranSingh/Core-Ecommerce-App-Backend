<?php

namespace Modules\MarketingEmployee\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\MarketingEmployee\Database\factories\MarketingLeadFactory;

class MarketingLead extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return MarketingLeadFactory::new();
    }
}
