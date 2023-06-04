<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Subjects extends Model
{
    use Notifiable, HasApiTokens, HasFactory;
    protected $table = 'subjects';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'classID',
        'teacherID',
    ];
    public $timestamps = false;
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacherID','id');
    }
}
