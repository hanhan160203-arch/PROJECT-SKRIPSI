<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::with('supplier')->get();

        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();

        return view('barang.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $rop = ($request->kebutuhan_harian * $request->lead_time) + $request->safety_stock;
       Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'supplier_id' => $request->supplier_id,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'kebutuhan_harian' => $request->kebutuhan_harian,
            'lead_time' => $request->lead_time,
            'safety_stock' => $request->safety_stock,
            'reorder_point' => $rop,
        ]);
        
        return redirect()->route('barang.index')
        ->with('success', 'Data barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);
        $suppliers = Supplier::all();

        return view('barang.edit', compact('barang', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barang = Barang::findOrFail($id);

    $rop = ($request->kebutuhan_harian * $request->lead_time) + $request->safety_stock;

    $barang->update([
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'supplier_id' => $request->supplier_id,
        'stok' => $request->stok,
        'satuan' => $request->satuan,
        'kebutuhan_harian' => $request->kebutuhan_harian,
        'lead_time' => $request->lead_time,
        'safety_stock' => $request->safety_stock,
        'reorder_point' => $rop,
    ]);

    return redirect()->route('barang.index')
        ->with('success', 'Data barang berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $barang = Barang::findOrFail($id);
        $barang->delete();

    return redirect()->route('barang.index')
        ->with('success', 'Data barang berhasil dihapus.');
    }
}
