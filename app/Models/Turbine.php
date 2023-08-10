<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turbine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'farm_id',
        'install_date',
        'status'
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function components()
    {
        return $this->belongsToMany(Component::class, 'turbine_components')
            ->withPivot('grade_id');
    }
}