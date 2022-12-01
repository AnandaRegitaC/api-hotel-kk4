<?php

namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = auth()->user();

        if ($auth->roles == 'admin') {
            $transactions = Transaction::with('hotel')->get();

            return response()->json([
                'success' => true,
                'message' => 'List Semua Transaksi',
                'data' => $transactions
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda Tidak Memiliki Akses',
                'data' => ''
            ], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $auth = auth()->user();

        if ($auth->roles == 'admin') {
            $transaction = Transaction::with('hotel')->findOrFail($id);
            $payment = Payment::where('transaction_id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Detail Transaksi',
                'data' => [
                    'transaction' => $transaction,
                    'payment' => $payment
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda Tidak Memiliki Akses',
                'data' => ''
            ], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $auth = auth()->user();

        if ($auth->roles == 'admin') {
            $transaction = Transaction::findOrFail($id);

            $transaction->update([
                'transaction_status' => 'SUCCESS',
            ]);

            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda Tidak Memiliki Akses',
                'data' => ''
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
