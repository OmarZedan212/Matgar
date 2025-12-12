<?php

namespace App\Http\Controllers;

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

        // UPDATED: Points to 'customer.shop' based on your error message
        return view('customer.shop', compact('products'));
    }

    /**
     * Display the specified product.
     * Route Name: customer.product
     */
    public function show($id)
    {
        // Find product or throw 404 error
        $products = Product::findOrFail($id)->with('category', 'seller.user');

        // Return the product detail view.
        // If you moved this file to the customer folder too, change this to 'customer.show'
        return view('shop.show', compact('products'));
    }
}
