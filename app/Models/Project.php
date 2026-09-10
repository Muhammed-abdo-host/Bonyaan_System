<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'name',
        'type',
        'location',
        'area',
        'floors',
        'status',
        'progress_percent',
        'budget',
        'image',
        'description',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'area' => 'float',
        'floors' => 'integer',
        'progress_percent' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function siteUpdates()
    {
        return $this->hasMany(SiteUpdate::class);
    }
}
