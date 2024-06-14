<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Paket_pembelian;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            // Log::info('Request headers:', $request->headers->all());
            // Log::info('Authenticated user:', Auth::guard('api')->user());
            // Periksa apakah pengguna telah login
        if (!Auth::guard('api')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Dapatkan ID pengguna yang saat ini login
        $user = Auth::guard('api')->user();
        $id_user = $user->id;

        try {
            // Dapatkan data keranjang yang terkait dengan pengguna yang saat ini login
            $data = Keranjang::where('id_user', $id_user)->with('paket_pembelian')->get();

            $formatData = $data->map(function ($newData) {
                return [
                    'id' => $newData->id,
                    'id_user' => $newData->id_user,
                    'id_barang' => $newData->id_barang,
                    'harga_barang' => $newData->harga_barang,
                    'nama_paket' => $newData->paket_pembelian->nama_paket,
                    'diskon' => $newData->paket_pembelian->diskon,
                    'gambar' => $newData->paket_pembelian->gambar,
                ];
            });
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika tidak ada data keranjang yang terkait dengan pengguna yang saat ini login
            return response()->json(['error' => 'id user tidak ditemukan'], 404);
        }

        // Kembalikan data keranjang
        return response()->json($formatData, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(string $id)
    // {

    //     if (!Auth::guard('api')->check()) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     $user = Auth::guard('api')->user();
    //     $id_user = $user->id; // Menggunakan ID pengguna yang diambil dari token JWT

    //     try {
    //         // Mencari paket_pembelian berdasarkan ID
    //         $paket_pembelian = Paket_pembelian::findOrFail($id);
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         // Jika paket_pembelian tidak ditemukan, kirim respons JSON error
    //         return response()->json(['error' => 'Produk tidak ditemukan'], 404);
    //     }

    //     $harga_barang = $paket_pembelian->harga_paket;

    //     $data = Keranjang::create([
    //         'id_user' => $id_user,
    //         'id_barang' => $id,
    //         'harga_barang' => $harga_barang,
    //     ]);

    //     return response($data, 200);
    // }
        public function store(Request $request, $id)
    {
        // dd($id);
        // // Debug logging
        //     Log::info('Request headers:', $request->headers->all());
        //     Log::info('Request body:', $request->all());
        //     Log::info('Authenticated user:', Auth::guard('api')->user());
        if (!Auth::guard('api')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::guard('api')->user();
        $id_user = $user->id;

        try {
            $paket_pembelian = Paket_pembelian::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        $harga_barang = $paket_pembelian->harga_paket;

        $data = Keranjang::create([
            'id_user' => $id_user,
            'id_barang' => $id,
            'harga_barang' => $harga_barang,
        ]);

        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang', 'data' => $data], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Keranjang $keranjang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keranjang $keranjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keranjang $keranjang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Log::info('Request headers:', $request->headers->all());
        // Log::info('Authenticated user:', Auth::guard('api')->user());
        if (!Auth::guard('api')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::guard('api')->user();
        $id_user = $user->id; // Menggunakan ID pengguna yang diambil dari token JWT

        try {
            // Mencari paket_pembelian berdasarkan ID
            $keranjang = Keranjang::findOrFail($id);

            if($id_user == $keranjang->id_user){
                $keranjang->delete();
            } else {
                return response()->json(['error' => 'Anda tidak diizinkan untuk menghapus keranjang ini'], 403);
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika paket_pembelian tidak ditemukan, kirim respons JSON error
            return response()->json(['error' => 'Keranjang tidak ditemukan'], 404);
        }

        return response()->json(['success' => 'data berhasil dihapus'], 200);
    }
}
