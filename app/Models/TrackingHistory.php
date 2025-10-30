<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingHistory extends Model
{
    protected $fillable = [
        'tracking_document_id',
        'status',
        'remarks',
        'updated_by',
    ];

    public function trackingDocument()
    {
        return $this->belongsTo(TrackingDocument::class);
    }
}
