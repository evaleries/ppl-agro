<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityEvent;
use App\Models\Product;

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

    public function show(Community $community)
    {
        return view('frontpages.community.show', [
            'community' => $community,
            'events' => CommunityEvent::where('community_id', $community->id)->latest()->paginate(5, ['*'], 'events'),
            'products' => Product::with('store')->where('store_id', $community->store->id)->latest()->paginate(10, ['*'], 'products'),
        ]);
    }

    public function event(CommunityEvent $event)
    {
        return view('frontpages.community.event', compact('event'));
    }
}
