<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'initials',
        'employee_number',
        'department_id',
        'procedure_id',
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    use HasFactory;
}
