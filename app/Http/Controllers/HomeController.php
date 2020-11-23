<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
}
