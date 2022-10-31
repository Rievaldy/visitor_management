<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tools extends Model
{
    protected $table = 'tools';

    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'description'
    ];
    protected $hidden = [
        'img'
    ];
}
