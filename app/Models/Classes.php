<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Axn\ModelsGenerator\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Classes extends Model
{
    protected $table = 'classes';
    public $timestamps = false;
    protected $fillable = ['name', 'teacher_id'];
}
