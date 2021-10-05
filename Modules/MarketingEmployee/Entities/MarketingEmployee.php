<?php

namespace Modules\MarketingEmployee\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\MarketingEmployee\Database\factories\MarketingEmployeeFactory;

class MarketingEmployee extends Model
{
    use HasFactory;

    protected $table = 'marketing_employee';
    protected $fillable = ['name', 'mobile', 'password'];

    protected static function newFactory()
    {
        return MarketingEmployeeFactory::new();
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
