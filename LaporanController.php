<?php

namespace App\Http\Controllers;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $barangMasuk = BarangMasuk::with('barang');
        $barangKeluar = BarangKeluar::with('barang');

        if ($request->tanggal_awal && $request->tanggal_akhir) {

            $barangMasuk->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);

            $barangKeluar->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        return view('laporan.index', [
            'barangMasuk' => $barangMasuk->get(),
            'barangKeluar' => $barangKeluar->get()
        ]);
    }



    public function pdf()
{
    $barangMasuk = BarangMasuk::with('barang')->get();
    $barangKeluar = BarangKeluar::with('barang')->get();

    return Pdf::loadView('laporan.pdf', [
        'barangMasuk' => $barangMasuk,
        'barangKeluar' => $barangKeluar,
    ])->stream('laporan-inventori.pdf');
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
