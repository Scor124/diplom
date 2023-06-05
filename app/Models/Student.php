<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static create($student)
 */
class Student extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'students';
    public $timestamps = false;
    protected $fillable = [
        'UserID',
        'class_id',
    ];
    public function user(){
        return $this->belongsTo(User::class,'UserID','id');
    }
    public function classes(){
        return $this->belongsTo(Classes::class,'class_id','id');
    }
    public function marks(){
        return $this->hasMany(Marks::class,'student_id','id');
    }
}
