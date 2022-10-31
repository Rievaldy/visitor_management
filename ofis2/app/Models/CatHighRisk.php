<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CatHighRisk extends Model
{
    protected $table = 'cat_high_risk';

    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'description'
    ];

    public function high_risk_tools()
    {
        return $this->hasMany(HighRiskTools::class, 'id_cat_high_risk', 'id');
    }
}
