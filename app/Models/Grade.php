<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'description'
    ];

    public function turbineComponents()
    {
        return $this->hasMany(TurbineComponent::class);
    }

    public function components()
    {
        return $this->hasMany(Component::class);
    }
}