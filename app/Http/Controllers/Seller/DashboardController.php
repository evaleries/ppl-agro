<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\CommunityEvent;
use App\Models\CommunityMember;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $community = auth()->user()->community;
        abort_if($community === null || $community->store->id === null, 403, 'Anda tidak memiliki komunitas atau toko!');

        $store = $community->store;
        return view('seller.dashboard', [
            'total_orders' => Order::where('store_id', $store->id)->count(),
            'total_products' => Product::where('store_id', $store->id)->count(),
            'total_events' => CommunityEvent::where('community_id', $community->id)->count(),
            'total_members' => CommunityMember::where('community_id', $community->id)->count(),
            'store' => $store,
            'community' => $community,
        ]);
    }
}
