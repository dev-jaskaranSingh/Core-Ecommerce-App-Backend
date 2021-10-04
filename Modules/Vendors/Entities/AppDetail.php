<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppDetail extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Vendors\Database\factories\AppDetailFactory::new();
    }
}
