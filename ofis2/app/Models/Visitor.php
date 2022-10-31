<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Visitor extends Model
{
    use HasFactory, Notifiable;

    protected $table = "visitor";
    protected $fillable = array('id_company', 'prefix','number','name','email','ktp');
    protected $guarded = array('id','created_at','updated_at');
    protected $primaryKey = "id";
    public $incrementing = false;

    public function company(){
        return $this->belongsTo(Company::class, 'id_company');
    }
}
