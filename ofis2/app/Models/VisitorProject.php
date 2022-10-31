<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visitor;
use App\Models\VisitorProjectDevice;
use App\Models\VisitorVisit;

class VisitorProject extends Model
{
    use HasFactory;

    protected $table = 'visitor_project';
    public $timestamps = false;

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'id_visitor', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id');
    }

    public function visitor_project_device()
    {
        return $this->hasMany(VisitorProjectDevice::class, 'id_visitor_project');
    }

    public function visitor_visit()
    {
        return $this->hasMany(VisitorVisit::class, 'id_visitor_project');
    }
}
