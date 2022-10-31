<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\VisitorProject;

class Project extends Model
{
    use HasFactory, Notifiable;
    protected $table = "project";
    protected $primaryKey = "id";
    protected $fillable = [
        'id_purpose',
        'id_company',
        'id_supplier',
        'visitor_type',
        'name',
        'company_name',
        'visitor_email',
        'type',
        'status',
        'is_rejected',
        'reason',
        'expired_time'
    ];

    public function company(){
        return $this->belongsTo(Company::class, 'id_company');
    }

    public function visitor_type(){
        return $this->belongsTo(VisitorType::class, 'id_visitor_type');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
    public function purpose(){
        return $this->belongsTo(Purpose::class, 'id_purpose');
    }

    public function visitor_project()
    {
        return $this->hasMany(VisitorProject::class, 'id_project', 'id');
    }


    public function employee_project()
    {
        return $this->hasMany(EmployeeProject::class, 'id_project', 'id');
    }

    public function location_project()
    {
        return $this->hasMany(ProjectLocation::class, 'id_project', 'id');
    }
}
