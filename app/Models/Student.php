<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Axn\ModelsGenerator\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'students';
    public $timestamps = false;

    protected $fillable = ['name', 'class_id', 'user_id'];
}
