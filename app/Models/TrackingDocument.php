<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingDocument extends Model
{
    protected $fillable = [
        'tracking_no',
        'name',
        'source_office',
        'document_type',
        'privacy',
        'file_path',
        'file_name',
        'status',
        'origin_unit',
        'remarks',
        'uploaded_by',
    ];

    public function histories()
    {
        return $this->hasMany(TrackingHistory::class);
    }

    public function latestHistory()
    {
        return $this->hasOne(TrackingHistory::class)->latestOfMany();
    }
}
