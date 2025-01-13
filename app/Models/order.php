<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = ['id_user', 'grand_total', 'payment_method', 'payment_status', 'status', 'currency', 'shipping_amount', 'shopping_method', 'notes'];

    public function user() {
        return $this->belongsTo(user::class);
    }

    public function item() {
        return $this->hasMany(orderItem::class);
    }

    public function address() {
        return $this->hasOne(Address::class);
    }
}
