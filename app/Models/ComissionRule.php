<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComissionRule extends Model
{

    protected $guarded = [];
    protected $casts = [
        'origin' => 'array',
        'destination' => 'array'
    ];
}
