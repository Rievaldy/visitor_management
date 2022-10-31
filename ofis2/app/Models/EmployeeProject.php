<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProject extends Model
{
    use HasFactory;

    protected $table = 'employee_project';
    protected $primaryKey = "id";

    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
