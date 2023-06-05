<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Marks extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'marks';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'case_id',
        'student_id',
        'date',
        'mark',
    ];
    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','id');
    }

    public function subject()
    {
        return $this->belongsTo(Subjects::class,'case_id','id');
    }
}
