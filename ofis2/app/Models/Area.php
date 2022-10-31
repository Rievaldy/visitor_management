<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Area extends Model
{
    protected $table = 'areas';

    use HasFactory, Notifiable;
    protected $fillable = [
        'id_site',
        'id_location',
        'name',
        'cat_confidential',
        'risk_work',
        'risk_not_work'
    ];
}
