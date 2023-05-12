<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Axn\ModelsGenerator\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Model
{
    protected $table = 'teachers';
    public $timestamps = false;

    protected $fillable = ['name', 'user_id'];
}
