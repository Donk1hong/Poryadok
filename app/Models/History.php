<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = ['folder_name', 'files_count', 'details'];

    protected $casts = [
        'details' => 'array',
    ];
}
