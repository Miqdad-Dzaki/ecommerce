<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'Image', 'is_activ'];

    public function Products() {
        return $this->hasMany(Products::class);
    }
}
