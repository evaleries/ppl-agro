<?php

namespace App\Http\Controllers;

use App\Models\CartSession;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /** @var CartSession */
    protected $cart;

    public function __construct(CartSession $cart)
    {
        $this->middleware(function ($request, $next) use ($cart) {
            $this->cart = $cart->from(session()->get($cart->sessionName, []));

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->has('product')) {
            $this->cart->add(Product::findOrFail($request->get('product')), $request->get('quantity', 1));
            return redirect()->route('cart');
        }

        return view('frontpages.cart', [
            'cartItems' => $this->cart->all(),
            'grandTotal' => $this->cart->grandTotal(),
            'ppn' => $this->cart->ppn(),
            'subTotal' => $this->cart->subTotal(),
        ]);
    }

    /**
     * @param Request $request
     * @param Product $product
     */
    public function addItem(Request $request, Product $product)
    {
        $this->cart->add($product, $request->get('quantity', 1));

        return redirect()->route('cart');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateItem(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|numeric|exists:products,id',
            'quantity' => 'required|numeric'
        ]);

        $product = Product::findOrFail($request->get('product_id'));
        $this->cart->update($product, $request->get('quantity'));

        return response()->json([
            'price' => $this->cart->asIDR($product->price),
            'total_price' => $this->cart->asIDR($product->price * $request->get('quantity')),
            'grandTotal' => $this->cart->grandTotalAsIDR(),
            'ppn' => $this->cart->ppnAsIDR(),
            'subTotal' => $this->cart->subTotalAsIDR(),
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'grandTotal' => $this->cart->grandTotalAsIDR(),
            'ppn' => $this->cart->ppnAsIDR(),
            'subTotal' => $this->cart->subTotalAsIDR(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function removeItem(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|numeric|exists:products,id'
        ]);
        $product = Product::findOrFail($request->get('product_id'));
        $this->cart->remove($product->id);

        return response()->json(['message' => 'Deleted'], 200);
    }
}
