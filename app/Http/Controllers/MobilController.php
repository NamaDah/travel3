<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobil = Mobil::latest()->get();

        if (is_null($mobil->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Mobil tidak ditemukan satupun!'
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Mobil ditemukan!',
            'data' => $mobil,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'brand_mobil' =>'required|string|max:255',
            'warna_mobil' =>'required|string|max:255',
            'nomor_mobil' =>'required|integer|max:11',
        ]);

        if ($validate->fails()){
            return response()->json([
                'status' => 'gagal',
                'message' => 'Validasi eror!',
                'data' => $validate->errors(),
            ]);
        }

        $mobil = Mobil::create($request->all());

        $response = [
            'status' => 'berhasil',
            'message' => 'Mobil berhasi ditambahkan!',
            'data' => $mobil
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mobil = Mobil::find($id);

        if (is_null($mobil)) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Mobil tidak ditemukan!',
            ], 200);
        }

        $response = [
            'status' => 'berhasil',
            'message' => 'Mobil ditemukan',
            'data' => $mobil,
        ];
    
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mobil $mobil)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),
    [
        'nama_mobil' =>'required|string|max:255',
        'harga_mobil' =>'required|integer',
        'warna_mobil' =>'required|string|max:255',
    ]);

    if ($validate->fails()) {
        return response()->json([
            'status' => 'Gagal',
            'message' => 'Validasi Error!',
            'data' => $validate->erros(),
        ], 403);
    }

    $mobil = Mobil::find($id);

    if (is_null($mobil)) {
        return response()->json([
            'status' => 'Gagal',
            'message' => 'Mobil tidak ditemukan!',
            'data'=> $validate->errors(),
        ], 200);
    }

    $mobil->update($request->all());

    $response = [
        'status' => 'Berhasil',
        'message' => 'Mobil berhasil diupdate',
        'data' => $mobil,
    ];

    return response()->json($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mobil = Mobil::find($id);

        if (is_null($mobil)) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Mobil tidak ditemukan!',
            ], 200);
        }

        Mobil::destroy($id);

        return response()->json([
            'status' => 'Berhasil',
            'Message' => 'Mobil berhasil dihapus.',
        ], 200);


    }

    public function search($nama_mobil)
    {
        $mobil = Mobil::where('nama_mobil', 'like', '%'.$nama_mobil.'%')
            ->latest()->get();

        if (is_null($mobil->first())) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Tidak ada mobil yang dapat ditemukan'
            ], 200);
        }

        $response = [
            'status' => 'Berhasil',
            'message' => 'Mobil ditemukan.',
            'data' => $mobil,
        ];

        return response()->json($response, 200);
    }
}
