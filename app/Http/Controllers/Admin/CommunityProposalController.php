<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ProposalDataTable;
use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityProposal;
use Illuminate\Http\Request;

class CommunityProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProposalDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ProposalDataTable $dataTable)
    {
        return $dataTable->render('admin.proposal.index');
    }

    /**
     * Display the specified resource.
     *
     * @param CommunityProposal $proposal
     * @return \Illuminate\View\View
     */
    public function show(CommunityProposal $proposal)
    {
        return $this->edit($proposal);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CommunityProposal $proposal
     * @return \Illuminate\View\View
     */
    public function edit(CommunityProposal $proposal)
    {
        return view('admin.proposal.edit', compact('proposal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param CommunityProposal $proposal
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, CommunityProposal $proposal)
    {
        $this->validate($request, [
            'reject_reason' => 'required_if:action,reject|nullable|string'
        ]);

        if ($request->action === 'accept') {
            $proposal->user->assignRole('seller');
            $proposal->update([
                'approved_at' => now(),
            ]);
            Community::where('user_id', $proposal->user->id)->firstOr(function () use ($proposal) {
                return Community::create([
                    'user_id' => $proposal->user->id,
                    'is_active' => 0,
                    'name' => $proposal->name,
                    'logo' => $proposal->banner,
                    'description' => $proposal->description
                ]);
            });
            return redirect()->route('admin.proposals.index')->withSuccess('Pengajuan telah disetujui dan komunitas baru telah dibuat');
        }

        $proposal->update([
            'rejected_at' => now(),
            'reject_reason' => $request->reject_reason,
        ]);
        return redirect()->route('admin.proposals.index')->withSuccess('Pengajuan berhasil ditolak');
    }

}
