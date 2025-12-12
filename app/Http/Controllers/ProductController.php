<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display the shop page with filters (Category, Price, Rating).
     */
    public function index(Request $request)
    {
        // 1. Start Query
        $query = Product::query();

        // 2. Filter by Category
        // Expecting URL like: ?category[]=mobiles&category[]=laptops
        if ($request->filled('category')) {
            $query->whereIn('category', $request->category);
        }

        // 3. Filter by Max Price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 4. Filter by Rating
        // If rating is 4, we show products with 4 stars or more
        if ($request->filled('rating') && $request->rating > 0) {
            $query->where('rating', '>=', $request->rating);
        }

        // 5. Get Results (Paginated)
        // paginate(12) ensures 12 products per page
        $products = $query->paginate(12);

        // Append current filters to pagination links so they don't get lost
        $products->appends($request->all());

        return view('customer.shop', compact('products'));
    }

    /**
     * Display the specified product.
     * Route Name: customer.product
     */
    public function show($id)
        {
            $product = Product::with(['category.group', 'seller'])
                ->findOrFail($id);

            $products = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->limit(8)
                ->get();

            return view('customer.product', [
                'product'  => $product,
                'products' => $products,
            ]);
        }

}
