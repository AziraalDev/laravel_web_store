<?php

namespace App\Observers;

use App\Models\Product;

class WishListObserver
{
    public function updated(Product $product): void
    {
        if ($product->finalPrice < $product->getOriginal('finalPrice')) {
            $product->followers()->wherePivot('price', true)->get();
            // todo : job
        }

        if ($product->exist && !$product->getOriginal('exist')) {
            // todo : job
        }
    }
}
