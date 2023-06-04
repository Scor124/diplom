<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Model
{
    protected $table = 'teachers';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'UserID',
        'Qualification'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'UserID','id');
    }
    public function subjects()
    {
        return $this->hasMany(Subjects::class,'teacherID','id');
    }
}
