<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity'
    ];

    public function turbines()
    {
        return $this->belongsToMany(Turbine::class, 'turbine_components')
            ->withPivot('grade_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    
}