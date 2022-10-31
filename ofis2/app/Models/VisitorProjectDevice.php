<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorProjectDevice extends Model
{
    use HasFactory;

    protected $table = 'visitor_project_devices';

    public function device(){
        return $this->belongsTo(Device::class, 'id_device');
    }

    public function purpose(){
        return $this->belongsTo(PurposeDevice::class, 'id_purpose');
    }

    public function visitor(){
        return $this->belongsTo(Visitor::class, 'id_visitor');
    }

    public function visitor_project(){
        return $this->belongsTo(VisitorProject::class, 'id_visitor_project');
    }
}
