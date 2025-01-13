<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = ['id_category', 'id_brand','name', 'slug', 'description', 'price', 'stock',  'image'];

    protected $casts =[
        'image' => 'array',
    ];

    public function categories(){
        return $this->belongsTo(Categories::class, 'id_category');
    }

    public function brands(){
        return $this->belongsTo(brand::class, 'id_brand');
    }

    public function orderItems() {
        return $this->hasMany(orderItem::class);
    }
}
