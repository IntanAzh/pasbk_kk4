<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Efood;
use Illuminate\Http\Request;

class efoodController extends Controller
{
    
    public function index()
    {
        $efood = Efood::all();

        return response()->json([
            'massage' => 'Data Food Berhasil Ditampilkan',
            'data' => $efood,
        ], 200); 
    }

    public function show($id)
    {
        $efood = Efood::find($id);

        if ($efood) {
            return response()->json([
                'message' => 'Data Food berhasil ditampilkan',
                'data' => $efood,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Data Food tidak ditemukan',
            ], 400);
        }
    }
}

    