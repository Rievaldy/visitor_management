<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighRiskTools extends Model
{
    use HasFactory;
    protected $table = 'high_risk_tools';
    public $timestamps = false;

    public function tools()
    {
        return $this->belongsTo(Tools::class, 'id_tools', 'id');
    }

    public function catHighRisk()
    {
        return $this->belongsTo(CatHighRisk::class, 'id_cat_high_risk', 'id');
    }


}
