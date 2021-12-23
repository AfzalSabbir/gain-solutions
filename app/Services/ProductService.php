<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ProductService
{
    /**
     * get all products with related data
     *
     * @param Request $request
     */
    public function getAllProducts(Request $request)
    {
        $products = Product::with('category', 'productVariants');
        if ($request->filled('search')) {
            $products->whereLike(['title', 'category.title', 'productVariants.sku'], $request->search);
        }
//        return $products->get();
        return $products->latest()->paginate($request->get('per_page', 15));
    }
}
