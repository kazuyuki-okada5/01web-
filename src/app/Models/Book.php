<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
        protected $fillable = [
        'name',
        'start_date',
        'start_time',
        'end_time',
        'break_hours',
        'total_hours',
    ];

    protected $dates = ['start_date', 'start_time', 'end_time'];

    public $timestamps = false; 
}
