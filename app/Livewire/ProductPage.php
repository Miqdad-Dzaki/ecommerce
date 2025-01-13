<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Products; // Ensure this path is correct and the Product class exists in this namespace

class ProductPage extends Component
{
    public function render()
    {
        $products = Products::all();
        return view('livewire.product-page', compact('products'));
    }

    public function show($id)
    {
        $product = Products::find($id);
        return view('livewire.product-detail-page', compact('product'));
    }
}
