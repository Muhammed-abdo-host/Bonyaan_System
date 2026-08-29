<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplicant extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'position', 'cv_path', 'status'];

}
