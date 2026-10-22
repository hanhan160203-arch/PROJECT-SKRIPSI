<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalBarang = Barang::count();
    $totalSupplier = Supplier::count();
    $totalBarangMasuk = BarangMasuk::count();
    $totalBarangKeluar = BarangKeluar::count();

    $stokMinimum = Barang::whereColumn('stok', '<=', 'reorder_point')->get();

    $grafikMasuk = BarangMasuk::select(
    'barang_id',
    DB::raw('SUM(jumlah) as total')
        )
        ->with('barang')
        ->groupBy('barang_id')
        ->orderByDesc('total')
        ->get();

        $grafikKeluar = BarangKeluar::select(
            'barang_id',
            DB::raw('SUM(jumlah) as total')
        )
        ->with('barang')
        ->groupBy('barang_id')
        ->orderByDesc('total')
        ->get();

        $namaBarang = Barang::pluck('nama_barang', 'id');

        $dataMasuk = [];
        $dataKeluar = [];

        foreach ($namaBarang as $id => $nama) {

            $masuk = $grafikMasuk->firstWhere('barang_id', $id);
            $keluar = $grafikKeluar->firstWhere('barang_id', $id);

            $dataMasuk[] = $masuk ? $masuk->total : 0;
            $dataKeluar[] = $keluar ? $keluar->total : 0;
        }

        $labelBarang = $namaBarang->values()->toArray();

    return view('dashboard', compact(
        'totalBarang',
        'totalSupplier',
        'totalBarangMasuk',
        'totalBarangKeluar',
        'stokMinimum',
        'labelBarang',
        'dataMasuk',
        'dataKeluar'
    ));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
