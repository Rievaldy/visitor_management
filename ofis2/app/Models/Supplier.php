<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Supplier extends Model
{
    protected $table = 'supplier';

    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'description'
    ];
}
