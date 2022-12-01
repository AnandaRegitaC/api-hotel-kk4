<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookHotelController extends Controller
{
    public function store(Hotel $hotel, Request $request)
    {
        $formated_date_1 = Carbon::parse($request->date_end);
        $formated_date_2 = Carbon::parse($request->date_start);

        $price = $hotel->price * $request->people;
        $total_days =  $formated_date_1->diffInDays($formated_date_2);
        $total_price = $price * $total_days;

        $transaction = Transaction::create([
            'hotel_id' => $hotel->id,
            'user_id' => $request->user()->id,
            'transaction_code' => 'TRX' . mt_rand(10000, 99999) . mt_rand(100, 999),
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'phone' => $request->user()->phone,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'people' => $request->people,
            'transaction_total' => $total_price,
            'transaction_status' => 'PENDING',
        ]);


        if ($transaction) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil, silahkan lanjutkan pembayaran'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal, silahkan coba lagi'
            ], 409);
        }
    }
}
