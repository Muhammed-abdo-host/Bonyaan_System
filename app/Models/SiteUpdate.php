<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteUpdate extends Model
{
    protected $fillable = ['project_id', 'title', 'description', 'image_path', 'phase'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
