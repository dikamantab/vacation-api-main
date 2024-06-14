<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kategori::all();

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try{
            if($request->file('gambar')){
                $image = $request->file('gambar');
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);


                $data = Kategori::create([
                    'nama_kategori' => $request->input('nama_kategori'),
                    'gambar' => $imageName,
                    'keterangan' => $request->input('keterangan'),
                ]);

                return response()->json($data, 200);

            } else {
                $data = Kategori::create([
                    'nama_kategori' => $request->input('nama_kategori'),
                    'gambar' => $request->input('gambar'),
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
            $data = Kategori::findOrFail($id);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['pesan' => 'Data tidak ditemukan'] ,404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nama_kategori' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try{if($request->file('gamber')){

            $image = $request->file('gambaer');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            Kategori::findOrFail($id)->update([
                'nama_kategori' => $request->input('nama_kategori'),
                'gambar' => $imageName,
                'keterangan' => $request->input('keterangan'),
            ]);

            return response()->json(["pesan" => "Berhasil Update data paket pembelian"], 200);
        } else {
            Kategori::findOrFail($id)->update([
                'nama_kategori' => $request->input('nama_kategori'),
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
            Kategori::findOrFail($id)->delete();

            return response()->json(['pesan' => 'data berhasil dihapus'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['pesan' => 'data tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['pesan' => 'Gagal untuk menghapus data'], 500);
        }
    }
}
