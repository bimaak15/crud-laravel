<?php

namespace App\Http\Controllers;
use App\Models\Konser;
use Illuminate\Http\Request;

class KonserController extends Controller
{
   public function index (Request $request) 
   {
    $konser = Konser::all();

    return response()->json([
        'konser' => $konser,
    ], 200);
   }
}