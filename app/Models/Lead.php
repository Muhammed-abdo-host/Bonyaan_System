<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
   protected $fillable = [
    'name', 'email', 'phone', 'location', 'building_type',
    'area', 'floors', 'finishing_tier', 'extras', 'estimated_cost', 'notes', 'status',
];
protected $casts = [
    'extras' => 'array',
];
}
