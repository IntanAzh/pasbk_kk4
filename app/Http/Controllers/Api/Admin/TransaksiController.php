<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\pembayaran;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::with(['efood'])->get();

        return ResponseFormatter:: success(
            $transaksi,
            'Data list transaksi berhasil di ambil'
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Transaksi::findOrFail($id);
        $payment = Payment::where('transaksi_id', $id)->first();

        return ResponseFormatter::success([
            'transaksi' => $data,
            'payment' => $payment
        ], 'Data transaksi berhasil di ambil');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $transaksi = Transaksi::findOrFail($id)->update(['status' => 'SUCCESSFUL']);
        return ResponseFormatter::success($transaksi, 'Transaksi berhasil di update, Pembayaran Sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id)->delete();
        return ResponseFormatter::success($transaksi, 'Transaksi berhasil di hapus');
    }

    public function cancel($id)
    {
        $transaksi = Transaksi::findOrFail($id)->update(['status' => 'FAILED']);
        return ResponseFormatter::success($transaksi, 'Transaksi berhasil di batalkan');
    }
}
