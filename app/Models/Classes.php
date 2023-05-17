<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Classes extends Model
{
    use Notifiable, HasApiTokens, HasFactory;
    protected $table = 'classes';

    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'formation_date'
    ];
    protected $casts = [
        'formation_date' => 'datetime:Y-m-d',
    ];


    public $timestamps = false;
}
