<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurbineComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'turbine_id',
        'component_id',
        'grade_id'
    ];
}