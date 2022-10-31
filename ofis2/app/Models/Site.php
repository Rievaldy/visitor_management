<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Site extends Model
{
    protected $table = 'sites';

    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'address'
    ];
}
