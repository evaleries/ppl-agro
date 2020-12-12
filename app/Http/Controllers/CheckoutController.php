<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\CartSession;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentBank;
use App\Models\PaymentEWallet;
use App\Models\RajaOngkir;
use App\Models\Shipping;
use App\Models\Store;
use App\Models\Payment;
use App\Models\StoreBalance;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
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

    public function index()
    {
        if ($this->cart->items()->isEmpty()) {
            return redirect()->route('products');
        }

        return view('frontpages.checkout', [
            'cart' => $this->cart,
            'cartItems' => $this->cart->all(),
            'grandTotal' => $this->cart->grandTotal(),
            'ppn' => $this->cart->ppn(),
            'subTotal' => $this->cart->subTotal(),
        ]);
    }

    /**
     * @param CheckoutRequest $request
     * @param RajaOngkir $ongkir
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function process(CheckoutRequest $request, RajaOngkir $ongkir)
    {
        if (!session()->has('checkout_session')) {
            session()->put('checkout_session', uniqid('CHECKOUT_'.auth()->user()->id, true));
        }

        DB::beginTransaction();
        try {
            foreach ($this->cart->groupByStore() as $storeId => $cartItems) {
                $store = Store::with('city')->findOrFail($storeId);
                $weightFromStore = $this->cart->weightFromStore($storeId);
                $shippingService = $ongkir->getService(
                    $store->city->id,
                    $request->get('shipping_city_id'),
                    $weightFromStore,
                    $request->shipping_methods[$storeId] ?? '-',
                    $request->shipping_services[$storeId] ?? '-');

                $shippingCost = $shippingService->cost[0]->value ?? 0;

                if ($shippingCost === 0) {
                    throw new \RuntimeException('Invalid shipping cost!');
                }

                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'store_id' => $storeId,
                    'status' => Order::STATUS_PENDING,
                    'shipping_cost' => $shippingCost,
                    'description' => $request->get('description'),
                ]);

                $totalAmount = 0;
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'price' => $item['product']->price,
                        'quantity' => $item['quantity']
                    ]);

                    $item['product']->update([
                        'stock' => $item['product']->stock - $item['quantity']
                    ]);

                    $totalAmount += $item['product']->price * $item['quantity'];
                }
                $totalAmount += $shippingCost;

                $invoice = Invoice::create([
                    'order_id' => $order->id,
                    'amount' => $totalAmount,
                    'status' => Invoice::STATUS_UNPAID,
                    'due_date' => $due = now()->format('Y-m-d'),
                    'number' => uniqid(implode('/', ['INV', $due, $order->id]), true)
                ]);

                $payment = Payment::create([
                    'invoice_id' => $invoice->id,
                    'method' => $request->get('payment_method'),
                    'status' => Payment::STATUS_PENDING,
                    'amount' => $totalAmount
                ]);
                if ($request->get('payment_method') === 'bank') {
                    PaymentBank::create([
                        'payment_id' => $payment->id,
                        'account_number' => $request->get('account_number'),
                        'bank_code' => $request->get('bank'),
                    ]);
                } elseif ($request->get('payment_method') === 'ewallet') {
                    PaymentEWallet::create([
                        'payment_id' => $payment->id,
                        'phone_number' => $request->get('phone_number'),
                        'wallet_type' => $request->get('ewallet')
                    ]);
                }

                $userAddress = UserAddress::where('user_id', $request->user()->id)->firstOr(function() use ($request) {
                    return UserAddress::create([
                        'user_id' => $request->user()->id,
                        'name' => $request->get('shipping_name'),
                        'address' => $request->get('shipping_address'),
                        'city_id' => $request->get('shipping_city_id'),
                        'province_id' => $request->get('shipping_province_id'),
                        'zipcode' => $request->get('shipping_zipcode'),
                        'phone' => $request->get('shipping_phone')
                    ]);
                });

                Shipping::create([
                    'order_id' => $order->id,
                    'user_address_id' => $userAddress->id,
                    'sender_city' => $store->city->id,
                    'receiver_city' => $userAddress->city_id,
                    'shipper' => $request->shipping_methods[$storeId] ?? 'Unknown',
                    'service' => $request->shipping_services[$storeId] ?? 'Unknown',
                    'estimated_delivery' => str_replace(['hari', 'HARI'], '', $shippingService->cost[0]->etd ?? '30'),
                    'weight' => $weightFromStore,
                    'status' => Shipping::STATUS_PENDING
                ]);

                StoreBalance::create([
                    'store_id' => $store->id,
                    'amount' => $totalAmount,
                    'type' => StoreBalance::TYPE_PENDING,
                    'description' => 'Pembayaran untuk Order #'.$order->id
                ]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage())->withInput();
        }

        DB::commit();
        $this->cart->clear();
        return redirect()->route('checkout.success');
    }

    /**
     * Successful checkout page
     */
    public function success()
    {
        $this->checkActiveCheckout();
        session()->forget('checkout_session');

        return view('frontpages.checkout_success');
    }

    /**
     * Check session
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkActiveCheckout()
    {
        if (! session()->has('checkout_session')) {
            return redirect()->route('home');
        }
    }
}