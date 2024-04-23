<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Pesanan = Pesanan::latest()->get();

        if (is_null($Pesanan->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Pesanan tidak ditemukan!'
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Pesanan ditemukan!',
            'data' => $Pesanan,
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
            'nama_Pesanan' =>'required|string|max:255',
            'harga_Pesanan' =>'required|integer',
            'warna_Pesanan' =>'required|string|max:255',
        ]);

        if ($validate->fails()){
            return response()->json([
                'status' => 'gagal',
                'message' => 'Validasi eror!',
                'data' => $validate->errors(),
            ]);
        }

        $Pesanan = Pesanan::create($request->all());

        $response = [
            'status' => 'berhasil',
            'message' => 'Pesanan berhasi ditambahkan!',
            'data' => $Pesanan
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Pesanan = Pesanan::find($id);

        if (is_null($Pesanan)) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pesanan tidak ditemukan!',
            ], 200);
        }

        $response = [
            'status' => 'berhasil',
            'message' => 'Pesanan ditemukan',
            'data' => $Pesanan,
        ];
    
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $Pesanan)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),
    [
        'nama_Pesanan' =>'required|string|max:255',
        'harga_Pesanan' =>'required|integer',
        'warna_Pesanan' =>'required|string|max:255',
    ]);

    if ($validate->fails()) {
        return response()->json([
            'status' => 'Gagal',
            'message' => 'Validasi Error!',
            'data' => $validate->erros(),
        ], 403);
    }

    $Pesanan = Pesanan::find($id);

    if (is_null($Pesanan)) {
        return response()->json([
            'status' => 'Gagal',
            'message' => 'Pesanan tidak ditemukan!',
            'data'=> $validate->errors(),
        ], 200);
    }

    $Pesanan->update($request->all());

    $response = [
        'status' => 'Berhasil',
        'message' => 'Pesanan berhasil diupdate',
        'data' => $Pesanan,
    ];

    return response()->json($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Pesanan = Pesanan::find($id);

        if (is_null($Pesanan)) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Pesanan tidak ditemukan!',
            ], 200);
        }

        Pesanan::destroy($id);

        return response()->json([
            'status' => 'Berhasil',
            'Message' => 'Pesanan berhasil dihapus.',
        ], 200);


    }

    public function search($nama_Pesanan)
    {
        $Pesanan = Pesanan::where('nama_Pesanan', 'like', '%'.$nama_Pesanan.'%')
            ->latest()->get();

        if (is_null($Pesanan->first())) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Tidak ada Pesanan yang dapat ditemukan'
            ], 200);
        }

        $response = [
            'status' => 'Berhasil',
            'message' => 'Pesanan ditemukan.',
            'data' => $Pesanan,
        ];

        return response()->json($response, 200);
    }
}
