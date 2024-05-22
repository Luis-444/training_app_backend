<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'abbreviation',
    ];

    public function procedure(){
        return $this->belongsTo(Procedure::class);
    }

    use HasFactory;
}
