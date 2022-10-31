<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Device extends Model
{
    protected $table = 'devices';

    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'description'
    ];
}
