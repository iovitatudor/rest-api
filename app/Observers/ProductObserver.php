<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    /**
     * @param Product $product
     */
    public function creating(Product $product): void
    {
        $slug = Str::slug($product->name);

        $duplicate = Product::select('slug')->where('slug', $slug)->first();

        if ($duplicate) {
            $slug = $slug . '-' . uniqid();
        }

        $product->slug = $slug ?? uniqid();
    }
}
