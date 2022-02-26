<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Message extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email', 'password', 'first_name', 'last_name', 'phone', 'gender', 'age',
    ];
}
