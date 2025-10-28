<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gazette extends Model
{
    protected $fillable = [
        'title',
        'category',
        'file_path',
        'file_name',
        'visibility',
    ];
}
