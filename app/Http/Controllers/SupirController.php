<?php

namespace App\Http\Controllers;

use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class SupirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Supir = Supir::latest()->get();

        if (is_null($Supir->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Supir tidak ditemukan!'
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Supir ditemukan!',
            'data' => $Supir,
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
            'nama_Supir' =>'required|string|max:255',
            'harga_Supir' =>'required|integer',
            'warna_Supir' =>'required|string|max:255',
        ]);

        if ($validate->fails()){
            return response()->json([
                'status' => 'gagal',
                'message' => 'Validasi eror!',
                'data' => $validate->errors(),
            ]);
        }

        $Supir = Supir::create($request->all());

        $response = [
            'status' => 'berhasil',
            'message' => 'Supir berhasi ditambahkan!',
            'data' => $Supir
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Supir = Supir::find($id);

        if (is_null($Supir)) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Supir tidak ditemukan!',
            ], 200);
        }

        $response = [
            'status' => 'berhasil',
            'message' => 'Supir ditemukan',
            'data' => $Supir,
        ];
    
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supir $Supir)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),
    [
        'nama_Supir' =>'required|string|max:255',
        'harga_Supir' =>'required|integer',
        'warna_Supir' =>'required|string|max:255',
    ]);

    if ($validate->fails()) {
        return response()->json([
            'status' => 'Gagal',
            'message' => 'Validasi Error!',
            'data' => $validate->erros(),
        ], 403);
    }

    $Supir = Supir::find($id);

    if (is_null($Supir)) {
        return response()->json([
            'status' => 'Gagal',
            'message' => 'Supir tidak ditemukan!',
            'data'=> $validate->errors(),
        ], 200);
    }

    $Supir->update($request->all());

    $response = [
        'status' => 'Berhasil',
        'message' => 'Supir berhasil diupdate',
        'data' => $Supir,
    ];

    return response()->json($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Supir = Supir::find($id);

        if (is_null($Supir)) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Supir tidak ditemukan!',
            ], 200);
        }

        Supir::destroy($id);

        return response()->json([
            'status' => 'Berhasil',
            'Message' => 'Supir berhasil dihapus.',
        ], 200);


    }

    public function search($nama_Supir)
    {
        $Supir = Supir::where('nama_Supir', 'like', '%'.$nama_Supir.'%')
            ->latest()->get();

        if (is_null($Supir->first())) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Tidak ada Supir yang dapat ditemukan'
            ], 200);
        }

        $response = [
            'status' => 'Berhasil',
            'message' => 'Supir ditemukan.',
            'data' => $Supir,
        ];

        return response()->json($response, 200);
    }
}
