<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Location;

class ProjectLocation extends Model
{
    use HasFactory, Notifiable;
    protected $table = "project_location";
    protected $primaryKey = "id";
    protected $fillable = [
        'id_project',
        'id_site',
        'id_location',
        'id_area',
        'id_purpose',
        'is_working',
        'date_start',
        'date_end',
        'time_start',
        'time_end',
        'cat_confidential_area',
        'risk_category',
        'is_need_nda'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_location', 'id');
    }
    public function site()
    {
        return $this->belongsTo(Site::class, 'id_site', 'id');
    }

    public function purpose()
    {
        return $this->belongsTo(Purpose::class, 'id_purpose', 'id');
    }


}
