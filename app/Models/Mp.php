<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mp extends Model
{
    protected $table = 'mp';

    protected $casts = [
        'config' => 'array',
    ];

}
