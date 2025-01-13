<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Products;

class ProductDetailPage extends Component
{
    public $productId;

    public function render()
    {
        $product = Products::find($this->productId);
        return view('livewire.product-detail-page', ['product' => $product]);
    }
}
