<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::guard('api')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::guard('api')->user();
        $id_user = $user->id; // Menggunakan ID pengguna yang diambil dari token JWT

        try {
            // Ambil semua transaksi yang memiliki id_user yang sama dengan id_user pada tabel keranjang
            $data = Transaksi::join('keranjang', 'transaksi.id_keranjang', '=', 'keranjang.id')
            ->join('paket_pembelian', 'keranjang.id_barang', '=', 'paket_pembelian.id')
            ->where('keranjang.id_user', $user->id)
            ->select('transaksi.*', 'paket_pembelian.nama_paket', 'paket_pembelian.diskon', 'keranjang.harga_barang')
            ->get();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['pesan' => 'Data tidak ditemukan'] ,404);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function showAll()
    {
        if (!Auth::guard('api')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::guard('api')->user();
        $id_user = $user->id; // Menggunakan ID pengguna yang diambil dari token JWT

        try {
            $data = Transaksi::join('keranjang', 'transaksi.id_keranjang', '=', 'keranjang.id')
            ->join('paket_pembelian', 'keranjang.id_barang', '=', 'paket_pembelian.id')
            ->select('transaksi.*', 'paket_pembelian.nama_paket', 'paket_pembelian.diskon', 'keranjang.harga_barang')
            ->get();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['pesan' => 'Data tidak ditemukan'] ,404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id, Request $request)
    {
        if (!Auth::guard('api')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::guard('api')->user();

        try {
            $id_user = $user->id; // Menggunakan ID pengguna yang diambil dari token JWT

            $keranjang = Keranjang::where('id', $id)
                                ->where('id_user', $id_user)
                                ->first();
                                
            if(!$keranjang) {
                return response()->json(['error' => 'Keranjang tidak ditemukan atau tidak milik pengguna ini'], 404);
            }

            if($request->file('gambar')){

                $image = $request->file('gambar');
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);


                $data = Transaksi::create([
                    'id_keranjang' => $id,
                    'bukti_pembayaran' => $imageName,
                    'status' => $request->input('status'),
                ]);

                return response()->json($data, 200);
            }

            $data = Transaksi::create([
                'id_keranjang' => $id,
                'bukti_pembayaran' => $request->input('gambar'),
                'status' => $request->input('status'),
            ]);

            return response()->json($data, 200);


        } catch  (\Exception $e) {
            return response()->json(['error' => $e]);
        }

        return response()->json( $data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
