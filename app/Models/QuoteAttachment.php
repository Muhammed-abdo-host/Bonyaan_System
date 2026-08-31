<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteAttachment extends Model
{
    protected $fillable = [
        'lead_id',
        'original_name',
        'path',
        'mime_type',
        'size',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}