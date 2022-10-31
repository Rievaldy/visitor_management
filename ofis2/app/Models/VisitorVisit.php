<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class VisitorVisit extends Model
{
    use HasFactory;

    protected $table = 'visitor_visit';

    public function user(){
        return $this->belongsTo(User::class, 'id_approved_by', 'id');
    }
}
