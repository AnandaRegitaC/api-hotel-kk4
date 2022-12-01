<?php

namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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


    public function store(Request $request)
    {
        $auth = $request->user();


        if ($auth->roles == 'admin') {
            $request->validate([
                'title' => 'required',
                'image' => 'required',
                'description' => 'required',
                'address' => 'required',
                'price' => 'required',
            ]);

            $image = $request->file('image')->store('hotel', 'public');

            $hotel = Hotel::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'image' => $image,
                'description' => $request->description,
                'address' => $request->address,
                'price' => $request->price,
            ]);

            if ($hotel) {
                return response()->json([
                    'success' => true,
                    'message' => 'Hotel Berhasil Ditambahkan',
                    'data' => $hotel
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Hotel Gagal Ditambahkan',
                    'data' => ''
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses',
                'data' => ''
            ], 401);
        }
    }

    public function show($id)
    {
        $hotel = Hotel::find($id);

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


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $auth = auth()->user();

        if ($auth->roles == 'admin') {
            $hotel = Hotel::find($id);

            if ($hotel) {


                if ($request->file('image') == '') {
                    $image = $hotel->image;
                } else {
                    $image = $request->file('image')->store('hotel', 'public');
                }

                $hotel->update([
                    'title' => $request->title ? $request->title : $hotel->title,
                    'slug' => Str::slug($request->title) ? Str::slug($request->title) : $hotel->slug,
                    'image' => $image ?? $hotel->image ?? null,
                    'description' => $request->description ? $request->description : $hotel->description,
                    'address' => $request->address ? $request->address : $hotel->address,
                    'price' => $request->price ? $request->price : $hotel->price,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Hotel Berhasil Diupdate',
                    'data' => $hotel
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Hotel Tidak Ditemukan',
                    'data' => ''
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda Bukan Admin',
                'data' => ''
            ], 404);
        }
    }

    public function destroy($id)
    {
        $user = auth()->user();

        if ($user->roles == 'admin') {
            $hotel = Hotel::find($id);

            if ($hotel) {
                $hotel->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Hotel Berhasil Dihapus',
                    'data' => $hotel
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Hotel Tidak Ditemukan',
                    'data' => ''
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda Bukan Admin',
                'data' => ''
            ], 404);
        }
    }
}
