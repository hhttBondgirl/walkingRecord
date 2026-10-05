<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class walkingRecord extends Model
{
    protected $fillable = [
    'walking_date',
    'time_zone',
    'minutes',
    'memo',
];
}
