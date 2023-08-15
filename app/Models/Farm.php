<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "address",
        "coordinates",
        "capacity",
        "launched_date",
        'status'
    ];

    public function turbines()
    {
        return $this->hasMany(Turbine::class);
    }
}