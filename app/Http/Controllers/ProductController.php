<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $products = Product::with(['store', 'ratings']);
        $header = 'Semua Produk';
        $category = null;

        $products->when($request->has('q'), function ($q) use ($request) {
            return $q->where('name', 'like', '%'.$request->get('q').'%')
                ->orWhere('description', $request->get('name'));
        });

        $products->when($request->has('price_min') && $request->has('price_max'), function ($q) use ($request) {
            return $q->orWhereBetween('price', [
                $request->get('price_min', 5000),
                $request->get('price_max', $request->get('price_min', 10000) + 1000000)
            ]);
        });

        $products->when($request->has('category'), function ($q) use ($request, &$header, &$category) {
            $category = ProductCategory::findOrFail($request->get('category'));
            $header = 'Kategori Produk: '. $category->name;
            return $q->orWhere('product_category_id', $request->get('category'));
        });

        $products->when($request->has('rating'), function ($q) use ($request) {
            return $q->orWhereHas('ratings', function ($q) use ($request) {
                return $q->where('rate', $request->get('rating'));
            });
        });

        $products = $products->paginate(6);
        return view('frontpages.products', compact('products', 'header', 'category'));
    }

    public function category($id)
    {
        $products = Product::with(['store', 'ratings'])->where('product_category_id', $id)->paginate(5);
        $category = ProductCategory::findOrFail($id);
        $header = $category->name;
        return view('frontpages.products', compact('products', 'id', 'category', 'header'));
    }
}
