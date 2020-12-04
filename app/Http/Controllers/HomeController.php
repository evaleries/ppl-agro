<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontpages.homepage', [
            'latest_products' => Product::with('category', 'images')->latest()->take(16)->get()
        ]);
    }

    /**
     * @param Store $store
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProduct(Store $store, Product $product)
    {
        return view('frontpages.show_product', compact('product'));
    }
}
