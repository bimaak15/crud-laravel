<?php

namespace App\Http\Controllers;

use App\Models\Konser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KonserController extends Controller
{
    public function index()
    {
        return response()->json(['konser' => Konser::all()], 200);
    }

    public function show($id)
    {
        $konser = Konser::find($id);

        if (!$konser) {
            return response()->json(['message' => 'Konser tidak ditemukan'], 404);
        }

        return response()->json(['konser' => $konser], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_konser' => 'required|string',
            'artis' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string',
            'harga_tiket' => 'required|integer|min:0',
            'kuota' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi Error', 'errors' => $validator->errors()], 422);
        }

        $konser = Konser::create($request->all());

        return response()->json(['message' => 'Konser berhasil ditambahkan', 'data' => $konser], 201);
    }

    public function update(Request $request, $id)
    {
        $konser = Konser::find($id);

        if (!$konser) {
            return response()->json(['message' => 'Konser tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_konser' => 'required|string',
            'artis' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string',
            'harga_tiket' => 'required|integer|min:0',
            'kuota' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi Error', 'errors' => $validator->errors()], 422);
        }

        $konser->update($request->all());

        return response()->json(['message' => 'Konser berhasil diperbarui'], 200);
    }

    public function destroy($id)
    {
        $konser = Konser::find($id);

        if (!$konser) {
            return response()->json(['message' => 'Konser tidak ditemukan'], 404);
        }

        $konser->delete();

        return response()->json(['message' => 'Konser berhasil dihapus'], 200);
    }
}