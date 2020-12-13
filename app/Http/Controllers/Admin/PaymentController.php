<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PaymentDataTable;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PaymentDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(PaymentDataTable $dataTable)
    {
        return $dataTable->render('admin.payment.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Payment $payment
     * @return \Illuminate\View\View
     */
    public function show(Payment $payment)
    {
        return view('admin.payment.show', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Payment $payment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Payment $payment)
    {
        $this->validate($request, [
            'action' => 'required|in:accept,reject'
        ]);

        DB::beginTransaction();
        try {
            if ($request->action === 'accept') {
                $payment->update(['status' => Payment::STATUS_RELEASED]);
                $payment->invoice->update(['status' => Invoice::STATUS_PAID]);
                $payment->invoice->order->update(['status' => Order::STATUS_PROCESSING]);
            } elseif ($request->action === 'reject') {
                $payment->update(['status' => Payment::STATUS_CANCELLED]);
                $payment->invoice->update(['status' => Invoice::STATUS_UNPAID]);
                $payment->invoice->order->update(['status' => Order::STATUS_CANCELLED]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        DB::commit();
        return response()->json(['status' => true]);
    }
}