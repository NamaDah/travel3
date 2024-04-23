<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Paket = Paket::latest()->get();

        if (is_null($Paket->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Paket tidak ditemukan!'
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Paket ditemukan!',
            'data' => $Paket,
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
            'nama_Paket' =>'required|string|max:255',
            'harga_Paket' =>'required|integer',
            'warna_Paket' =>'required|string|max:255',
        ]);

        if ($validate->fails()){
            return response()->json([
                'status' => 'gagal',
                'message' => 'Validasi eror!',
                'data' => $validate->errors(),
            ]);
        }

        $Paket = Paket::create($request->all());

        $response = [
            'status' => 'berhasil',
            'message' => 'Paket berhasi ditambahkan!',
            'data' => $Paket
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Paket = Paket::find($id);

        if (is_null($Paket)) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Paket tidak ditemukan!',
            ], 200);
        }

        $response = [
            'status' => 'berhasil',
            'message' => 'Paket ditemukan',
            'data' => $Paket,
        ];
    
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paket $Paket)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),
    [
        'nama_Paket' =>'required|string|max:255',
        'harga_Paket' =>'required|integer',
        'warna_Paket' =>'required|string|max:255',
    ]);

    if ($validate->fails()) {
        return response()->json([
            'status' => 'Gagal',
            'message' => 'Validasi Error!',
            'data' => $validate->erros(),
        ], 403);
    }

    $Paket = Paket::find($id);

    if (is_null($Paket)) {
        return response()->json([
            'status' => 'Gagal',
            'message' => 'Paket tidak ditemukan!',
            'data'=> $validate->errors(),
        ], 200);
    }

    $Paket->update($request->all());

    $response = [
        'status' => 'Berhasil',
        'message' => 'Paket berhasil diupdate',
        'data' => $Paket,
    ];

    return response()->json($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Paket = Paket::find($id);

        if (is_null($Paket)) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Paket tidak ditemukan!',
            ], 200);
        }

        Paket::destroy($id);

        return response()->json([
            'status' => 'Berhasil',
            'Message' => 'Paket berhasil dihapus.',
        ], 200);


    }

    public function search($nama_Paket)
    {
        $Paket = Paket::where('nama_Paket', 'like', '%'.$nama_Paket.'%')
            ->latest()->get();

        if (is_null($Paket->first())) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Tidak ada Paket yang dapat ditemukan'
            ], 200);
        }

        $response = [
            'status' => 'Berhasil',
            'message' => 'Paket ditemukan.',
            'data' => $Paket,
        ];

        return response()->json($response, 200);
    }
}
