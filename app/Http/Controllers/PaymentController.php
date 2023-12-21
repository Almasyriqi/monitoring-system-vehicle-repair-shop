<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Payment;
use App\Models\PaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::find($id);
            $payment->total = $request->total;
            $payment->payment_date = $request->payment_date;
            $payment->save();

            // check detail id
            $id_details = [];
            foreach ($request->repeater as $item) {
                if ($item['detail_id']) {
                    array_push($id_details, intval($item['detail_id']));
                }
            }

            // delete detail payment
            $payment_details = PaymentDetail::where('payment_id', $id)->get();
            foreach ($payment_details as $detail) {
                if ($detail->part_id != null) {
                    $part = Part::find($detail->part_id);
                    if (!in_array($detail->id, $id_details)) {
                        $part->stock = $part->stock + $detail->quantity;
                        $part->save();
                        $detail->delete();
                    }
                }
            }

            // new or update payment detail
            foreach ($request->repeater as $item) {
                if ($item['part_id'] != null) {
                    // update part detail
                    $part = Part::find($item['part_id']);

                    // cek payment detail
                    if ($item['detail_id'] == null) {
                        $payment_detail = new PaymentDetail();
                        $payment_detail->payment_id     = $payment->id;
                        $stock                          = $part->stock;
                    } else {
                        $payment_detail = PaymentDetail::find($item['detail_id']);
                        if ($payment_detail->part_id == $item['part_id']) {
                            $stock = $part->stock + $payment_detail->quantity;
                        } else {
                            $stock = $part->stock;
                        }
                    }

                    // validate quantity
                    if ($item['quantity'] > $stock) {
                        return back()->withErrors('The number of items must not be greater than the stock on hand!');
                    } else if ($item['quantity'] < 0) {
                        return back()->withErrors('The number of items cannot be less than 0!');
                    }
                    $part->stock = $stock - $item['quantity'];
                    $part->save();

                    // save payment detail
                    $amount = str_replace('Rp ', '', $item['amount']);
                    $amount = str_replace('.', '', $amount);
                    $amount = intval($amount);
                    $payment_detail->part_id    = $item['part_id'];
                    $payment_detail->quantity   = $item['quantity'];
                    $payment_detail->amount     = $amount;
                    $payment_detail->save();
                }
            }
            DB::commit();
            return redirect()->route('repair.show', $payment->repair->id)->with('success', 'Success update payment data');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
