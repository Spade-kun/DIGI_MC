<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminDocument extends Model
{
    protected $fillable = [
        'title',
        'case_no',
        'date_issued',
        'file_path',
        'file_name',
        'google_drive_id',
    ];

    protected $casts = [
        'date_issued' => 'date',
    ];
}
