<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'subject_id',
        'user_id',
        'room_id',
        'pair',
        'week_day',
        'date'
    ];
}
