<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProcedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'procedure_id',
    ];

    public function procedure(){
        return $this->belongsTo(Procedure::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

}
