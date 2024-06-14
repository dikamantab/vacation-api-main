<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = User::all();
            return response()->json($data, 200);
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
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'nomor_telepon' => 'required|string',
            'alamat' => 'required|string',
        ]);

        try{

                $data = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'nomor_telepon' => $request->input('nomor_telepon'),
                    'alamat' => $request->input('alamat'),
                ]);

                return response()->json($data, 200);

            }
        catch (\Exception $e) {
            return response()->json(['pesan' => 'Gagal untuk menyimpan data.' . $e->getMessage()], 500);
        }
    }


    public function loggedin() {
        return response()->json(['pesan' => 'anda harus login terlebih dahulu']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Lakukan proses otentikasi
        $credentials = $request->only('name', 'password');

        if ($token = JWTAuth::attempt($credentials)) {
            return response()->json(['token' => $token, 'id' => Auth::id(), 'name' => Auth::user()->name ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Lakukan proses otentikasi
        $credentials = $request->only('name', 'password');

        if ($token = JWTAuth::attempt($credentials)) {
            return response()->json(['token' => $token, 'id' => Auth::id(), 'name' => Auth::user()->name ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::findOrfail($id)->delete();

            return response()->json(["pesan" => "berhasil hapus data"], 200);

        } catch (\Exception $e) {
            return response()->json(["pesan" => "Gagal hapus data." . $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        try {
            $token = JWTAuth::getToken(); // Mendapatkan token dari pengguna yang saat ini masuk
            Log::info('Logout Token: ' . $token);

            $removeToken = JWTAuth::invalidate($token);

            if ($removeToken) {
                return response()->json(['message' => 'Successfully logged out']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout: ' . $e->getMessage()], 500);
        }
    }

}
