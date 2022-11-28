<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\efood;
use App\Models\transaksi;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    public function store(Request $request)
    {
        $user = auth()->user();
        $efood = Efood::find($request->food_id);

        if($user->role == 'user') {
            $request->validate([
                'food_id' => 'required',
                'name' => 'required',
                'alamat_order' => 'required',
                'total_order' => 'required',
                'date' => 'required',
                
            ]);

            $order = Transaksi::create([
                'food_id' => $request->food_id,
                'user_id' => $request->user_id,
                'name' => $request->name,
                'alamat_order' => $request->alamat_order,
                'total_order' => $request->total_order,
                'total_harga' => $request->total_order * $efood->harga,
                'date' => $request->date,
                'status' => 'pending',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Order berhasil ditambahkan',
                'data' => $order,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda bukan user'
            ], 400);
        }
    }

    public function index(Request $request)
    {
        $order = Transaksi::with(['efood'])->where('user_id', Auth::user()->id)->get();

        return ResponseFormatter::success(
            $order,
            'Data list order berhasil di ambil'
        );
    }

    public function prosesPaymentRent(Request $request) 
    {
        $image = $request->file('image')-> store('payment', 'public');

        $payment = Payment::create([
            'user_id' => Auth::user()->id,
            'transaksi_id' => $request->transaksi_id,
            'image' => $image,
            'name' => $request->name,
            'type' => $request->type,
        ]);

        Transaksi::where('id', $request->transaksi_id)->update([
            'status' => 'WAITING'
        ]);
        if ($payment){
            return ResponseFormatter::success($payment, 'success');
        } else {
            return ResponseFormatter::error(null, 'failed', 500);
        }
    }
}