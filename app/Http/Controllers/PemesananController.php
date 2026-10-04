<?php

namespace App\Http\Controllers;

use App\Models\Konser;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemesananController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'konser_id' => 'required|exists:konser,id',
            'jumlah_tiket' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Error'
            ], 422);
        }

        $konser = Konser::find($request->konser_id);

        if ($request->jumlah_tiket > $konser->kuota) {
            return response()->json([
                'message' => 'Kuota tiket tidak mencukupi'
            ], 422);
        }

        $pemesanan = Pemesanan::create([
            'user_id' => $request->user()->id,
            'konser_id' => $request->konser_id,
            'jumlah_tiket' => $request->jumlah_tiket,
            'status' => 'menunggu',
        ]);

        $konser->update(['kuota' => $konser->kuota - $request->jumlah_tiket]);

        return response()->json([
                'message' => 'Pemesanan berhasil', 
                'data' => $pemesanan
            ], 201);
    }

    public function index(Request $request)
    {
        $pemesanan = Pemesanan::with('konser')
            ->where('user_id', $request->user()->id)
            ->get();

        $data = $pemesanan->map(function ($item) {
            return [
                'id' => $item->id,
                'nama_konser' => $item->konser->nama_konser,
                'jumlah_tiket' => $item->jumlah_tiket,
                'status' => $item->status,
            ];
        });

        return response()->json([
                'pemesanan' => $data
            ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_tiket' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Error'
            ], 422);
        }

        $pemesanan = Pemesanan::find($id);

        if (!$pemesanan) {
            return response()->json([
                'message' => 'Pemesanan tidak ditemukan'
            ], 404);
        }

        if ($pemesanan->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Pemesanan bukan milik Anda'
            ], 403);
        }

        $pemesanan->update(['jumlah_tiket' => $request->jumlah_tiket]);

        return response()->json([
                'message' => 'Berhasil memperbarui pemesanan'
            ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $pemesanan = Pemesanan::find($id);

        if (!$pemesanan) {
            return response()->json([
                'message' => 'Pemesanan tidak ditemukan'
            ], 404);
        }

        if ($pemesanan->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Pemesanan bukan milik Anda'
            ], 403);
        }

        $pemesanan->update(['status' => 'dibatalkan']);

        return response()->json([
                'message' => 'Pemesanan dibatalkan'
            ], 200);
    }
}