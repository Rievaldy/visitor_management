<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Purpose extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'purpose';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'category',
        'description'
    ];
}
