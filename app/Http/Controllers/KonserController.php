<?php

namespace App\Http\Controllers;

use App\Models\Konser;

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
}