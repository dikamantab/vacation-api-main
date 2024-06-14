<?php

namespace App\Http\Controllers;

use App\Models\Paket_pembelian as ModelsPaket_pembelian;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class Paket_pembelian extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = ModelsPaket_pembelian::with('kategori')->get();

            $formattedData = $data->map(function ($paket) {
                return [
                    'id' => $paket->id,
                    'nama_paket' => $paket->nama_paket,
                    'kategori' => $paket->kategori ? $paket->kategori->nama_kategori : null,
                    'harga_paket' => $paket->harga_paket,
                    'gambar' => $paket->gambar,
                    'perlengkapan' => $paket->perlengkapan,
                    'diskon' => $paket->diskon,
                    'keterangan' => $paket->keterangan,
                ];
            });

            return response()->json($formattedData, 200);
        } catch (\Exception $e) {
            return response()->json(['pesan' => 'data tidak ditemukan'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama_paket' => 'required|string',
            'kategori_id' => 'required|integer',
            'harga_paket' => 'required|integer',
            'perlengkapan' => 'required|json',
            'diskon' => 'required|integer',
            'keterangan' => 'required|string',
        ]);

        try{
            if($request->file('gambar')){
                $image = $request->file('gambar');
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);


                $data = ModelsPaket_pembelian::create([
                    'nama_paket' => $request->input('nama_paket'),
                    'kategori_id' => $request->input('kategori_id'),
                    'harga_paket' => $request->input('harga_paket'),
                    'gambar' => $imageName,
                    'perlengkapan' => json_decode($request->input('perlengkapan')),
                    'diskon' => $request->input('diskon'),
                    'keterangan' => $request->input('keterangan'),
                ]);

                return response()->json($data, 200);

            } else {
                $data = ModelsPaket_pembelian::create([
                    'nama_paket' => $request->input('nama_paket'),
                    'kategori_id' => $request->input('kategori_id'),
                    'harga_paket' => $request->input('harga_paket'),
                    'gambar' => $request->input('gambar'),
                    'perlengkapan' => json_decode($request->input('perlengkapan')),
                    'diskon' => $request->input('diskon'),
                    'keterangan' => $request->input('keterangan'),
                ]);

                return response()->json($data, 200);
            }
        } catch (\Exception $e) {
            return response()->json(['pesan' => 'Gagal untuk menyimpan data.' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = ModelsPaket_pembelian::findOrFail($id);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['pesan' => 'Data tidak ditemukan'] ,404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nama_paket' => 'required|string',
            'kategori_id' => 'required|integer',
            'harga_paket' => 'required|integer',
            'perlengkapan' => 'required|json',
            'diskon' => 'required|integer',
            'keterangan' => 'required|string',
        ]);

        try{if($request->file('gamber')){

            $image = $request->file('gambaer');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $data = ModelsPaket_pembelian::findOrFail($id)->update([
                'nama_paket' => $request->input('nama_paket'),
                'kategori_id' => $request->input('kategori_id'),
                'harga_paket' => $request->input('harga_paket'),
                'gambar' => $imageName,
                'perlengkapan' => json_decode($request->input('perlengkapan')),
                'diskon' => $request->input('diskon'),
                'keterangan' => $request->input('keterangan'),
            ]);

            return response()->json(["pesan" => "Berhasil Update data paket pembelian"], 200);
        } else {
            $data = ModelsPaket_pembelian::findOrFail($id)->update([
                'nama_paket' => $request->input('nama_paket'),
                'kategori_id' => $request->input('kategori_id'),
                'harga_paket' => $request->input('harga_paket'),
                'perlengkapan' => json_decode($request->input('perlengkapan')),
                'diskon' => $request->input('diskon'),
                'keterangan' => $request->input('keterangan'),
            ]);

            return response()->json(["pesan" => "Berhasil Update data paket pembelian"], 200);
        }} catch (\Exception $e) {
            return response()->json(['pesan' => 'Gagal untuk menyimpan data.' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            ModelsPaket_pembelian::findOrFail($id)->delete();

            return response()->json(['pesan' => 'data berhasil dihapus'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['pesan' => 'data tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['pesan' => 'Gagal untuk menghapus data'], 500);
        }
    }
}
