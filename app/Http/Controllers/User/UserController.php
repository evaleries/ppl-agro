<?php

namespace App\Http\Controllers\User;

use App\DataTables\User\UserOrderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProposalStoreRequest;
use App\Models\Community;
use App\Models\CommunityProposal;
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
     * @TODO: add policy
     * @param Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        return view('frontpages.account.order_detail', compact('order'));
    }

    public function propose()
    {
        return view('frontpages.community.propose', [
            'proposal' => CommunityProposal::where('user_id', auth()->user()->id)->first()
        ]);
    }

    /**
     * @param ProposalStoreRequest $request
     * @return mixed
     */
    public function storeProposal(ProposalStoreRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('banner_file')) {
            $validated['banner'] = $request->file('banner_file')->store('public/community_logos');
        }

        if ($request->hasFile('ktp_file')) {
            $validated['ktp'] = $request->file('ktp_file')->store('public/ktps');
        }

        $validated['user_id'] = $request->user()->id;

        CommunityProposal::create($validated);

        return redirect()->back()->withSuccess('Pengajuan telah berhasil dikirim, admin akan segera meninjau pengajuan ini.');
    }

    public function overview()
    {
        return view('frontpages.account.overview', [
            'user' => auth()->user()
        ]);
    }
}
