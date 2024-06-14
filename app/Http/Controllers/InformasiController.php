<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Informasi::all();

        return response()->json($data, 200);
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
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try{
            if($request->file('gambar')){
                $image = $request->file('gambar');
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);


                $data = Informasi::create([
                    'title' => $request->input('title'),
                    'gambar' => $imageName,
                    'keterangan' => $request->input('keterangan'),
                ]);

                return response()->json($data, 200);

            } else {
                $data = Informasi::create([
                    'title' => $request->input('title'),
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
            $data = Informasi::findOrFail($id);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['pesan' => 'Data tidak ditemukan'] ,404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Informasi $informasi)
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
            'title' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try{if($request->file('gamber')){

            $image = $request->file('gambaer');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            Informasi::findOrFail($id)->update([
                'title' => $request->input('title'),
                'gambar' => $imageName,
                'keterangan' => $request->input('keterangan'),
            ]);

            return response()->json(["pesan" => "Berhasil Update data paket pembelian"], 200);
        } else {
            Informasi::findOrFail($id)->update([
                'title' => $request->input('title'),
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
        //
        try {
            Informasi::findOrFail($id)->delete();

            return response()->json(['pesan' => 'data berhasil dihapus'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['pesan' => 'data tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['pesan' => 'Gagal untuk menghapus data'], 500);
        }
    }
}
