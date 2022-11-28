<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Efood;
use Illuminate\Http\Request;

class efoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $efood = Efood::all();

        return response()->json([
            'massage' => 'Data Food Berhasil Ditampilkan',
            'data' => $efood,
        ], 200); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @porom \Illuminate\Http\Request 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
       
        if ($user->role == 'admin'){
            $request->validate([
                'name' => 'required',
                'harga'=> 'required',
                'stok_produk' => 'required',
                'image'=> 'required',
            ]);
            
            $efood = Efood::create([
                'name' => $request->name,
                'harga'=> $request->harga,
                'stok_produk' => $request->stok_produk,
                'image'=> $request->image,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Food berhasil ditambahkan',
                'data' => $efood,
            ], 200);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk menambahkan food',
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $efood = Efood::find($id);
        if ($efood) {
            return response()->json([
              'status' => 200,
              'data' => $efood

            ], 200);
        }else {
            return response()->json([
                'status' => 404,
                'message' => 'id atas' .$id . 'tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            $request->validate([
                'name' => 'required',
                'harga'=> 'required',
                'stok_produk' => 'required',
               
            ]);

            $efood = Efood::find($id);

            $efood->update([
                'name' => $request->name,
                'harga'=> $request->harga,
                'stok_produk' => $request->stok_produk,
                
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Food berhasil diubah',
                'data' => $efood,
            ], 200);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk mengubah data food',
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            $efood = Efood::find($id);

            $efood->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Food berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk menghapus data food',
            ], 401);
        }
    }
}
