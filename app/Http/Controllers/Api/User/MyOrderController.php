<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function index()
    {
        $orders = Transaction::with('hotel')->where('user_id', Auth::user()->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'List Semua Pesanan',
            'data' => $orders
        ], 200);
    }

    public function processPaymentHotel(Request $request)
    {
        $user = auth()->user();
        $image = $request->file('image')->store('payment', 'public');

        $payment = Payment::create([
            'user_id' => $user->id,
            'transaction_id' => $request->transaction_id,
            'image' => $image,
            'name' => $request->name,
            'type' => $request->type,
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);

        $transaction->update([
            'status' => 'WAITING',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan Berhasil Dibayar',
            'data' => $payment
        ], 200);
    }
}
