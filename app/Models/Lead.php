<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
       protected $fillable = [
        'name', 'email', 'phone', 'building_type',
        'area', 'floors', 'finishing_tier', 'estimated_cost', 'status',
    ];
}
