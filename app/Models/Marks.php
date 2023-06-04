<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'case_id',
        'student_id',
        'date',
        'mark',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
}
