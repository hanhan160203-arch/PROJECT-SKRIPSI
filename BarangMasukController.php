<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangMasuks = BarangMasuk::with(['barang','supplier'])->get();

        return view('barang_masuk.index', compact('barangMasuks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        $suppliers = Supplier::all();

        return view('barang_masuk.create', compact('barangs','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         BarangMasuk::create([
        'barang_id'   => $request->barang_id,
        'supplier_id' => $request->supplier_id,
        'user_id'     => auth()->id(),
        'tanggal'     => $request->tanggal,
        'jumlah'      => $request->jumlah,
    ]);

    $barang = Barang::findOrFail($request->barang_id);

    $barang->update([
        'stok' => $barang->stok + $request->jumlah
    ]);

    return redirect()->route('barang-masuk.index')
        ->with('success','Data barang masuk berhasil ditambahkan.');
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
         $barangMasuk = BarangMasuk::findOrFail($id);
        $barangs = Barang::all();
        $suppliers = Supplier::all();

        return view('barang_masuk.edit', compact('barangMasuk', 'barangs', 'suppliers'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        // kembalikan stok lama
        $barangLama = Barang::findOrFail($barangMasuk->barang_id);
        $barangLama->stok -= $barangMasuk->jumlah;
        $barangLama->save();

        // update transaksi
        $barangMasuk->update([
        'barang_id' => $request->barang_id,
        'supplier_id' => $request->supplier_id,
        'tanggal' => $request->tanggal,
        'jumlah' => $request->jumlah,
    ]);

        // tambahkan stok baru
        $barangBaru = Barang::findOrFail($request->barang_id);
        $barangBaru->stok += $request->jumlah;
        $barangBaru->save();

        return redirect()->route('barang-masuk.index')
            ->with('success','Data berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barang = Barang::findOrFail($barangMasuk->barang_id);
        $barang->stok -= $barangMasuk->jumlah;
        $barang->save();
        $barangMasuk->delete();

        return redirect()->route('barang-masuk.index')
        ->with('success','Data berhasil dihapus.');
    }
}
