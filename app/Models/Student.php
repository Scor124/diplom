<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static where(string $string, mixed $UserID)
 * @method static create($student)
 */
class Student extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'students';
    public $timestamps = false;

    protected $fillable = ['name', 'class_id', 'UserID'];
}
