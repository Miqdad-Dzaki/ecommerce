<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderItem extends Model
{
    use HasFactory;
    protected $fillable = ['id_order', 'id_product', 'quantity', 'unit_amount', 'total_amount'];

    public function order() {
        return $this->belongsTo(order::class);
    }

    public function Products() {
        return $this->belongsTo(Products::class);
    }
}
