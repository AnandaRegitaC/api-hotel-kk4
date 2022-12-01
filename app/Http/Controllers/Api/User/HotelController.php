<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();

        if ($hotels) {
            return response()->json([
                'success' => true,
                'message' => 'List Semua Hotel',
                'data' => $hotels
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Hotel Tidak Ditemukan',
                'data' => ''
            ], 404);
        }
    }

    public function show(Hotel $hotel)
    {
        if ($hotel) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Hotel',
                'data' => $hotel
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Hotel Tidak Ditemukan',
                'data' => ''
            ], 404);
        }
    }
}
