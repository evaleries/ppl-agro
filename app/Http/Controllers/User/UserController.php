<?php

namespace App\Http\Controllers\User;

use App\DataTables\User\UserOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function orders()
    {
        return view('frontpages.account.orders', [
            'orders' => Order::where('user_id', auth()->user()->id)->latest()->get()
        ]);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        return view('frontpages.account.order_detail', compact('order'));
    }

    public function overview()
    {
        return view('frontpages.account.overview', [
            'user' => auth()->user()
        ]);
    }
}
