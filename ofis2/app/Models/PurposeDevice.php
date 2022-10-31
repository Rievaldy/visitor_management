<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PurposeDevice extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'm_device_purpose';
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'desc'
    ];
}
