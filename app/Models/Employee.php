<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'trainner_email',
        'initials',
        'employee_number',
        'department_id',
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function procedures(){
        return $this->belongsToMany(Procedure::class, 'employee_procedures');
    }

    public function employee_procedures(){
        return $this->hasMany(EmployeeProcedure::class);
    }

    use HasFactory;
}
