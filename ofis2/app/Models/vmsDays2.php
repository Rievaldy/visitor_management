<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class vmsDays2 extends Model
{
    use HasFactory, Notifiable;

    protected $table = "vms_days";
	protected $primaryKey = "id";
}
