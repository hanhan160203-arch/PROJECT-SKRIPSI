<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangKeluars = BarangKeluar::with('barang')->get();

        return view('barang_keluar.index', compact('barangKeluars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();

        return view('barang_keluar.create', compact('barangs'));
    }


    public function store(Request $request)
    {
        $barang = Barang::findOrFail($request->barang_id);

        if($request->jumlah > $barang->stok){
            return back()->with('error','Stok tidak mencukupi.');
        }

        BarangKeluar::create([
            'barang_id' => $request->barang_id,
            'user_id' => auth()->id(),
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        $barang->update([
            'stok' => $barang->stok - $request->jumlah
        ]);

        return redirect()->route('barang-keluar.index')
            ->with('success','Data barang keluar berhasil ditambahkan.');
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
         $barangKeluar = BarangKeluar::findOrFail($id);
        $barangs = Barang::all();

        return view('barang_keluar.edit', compact('barangKeluar','barangs'));
    }

    public function update(Request $request, string $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $barangLama = Barang::findOrFail($barangKeluar->barang_id);
        $barangLama->stok += $barangKeluar->jumlah;
        $barangLama->save();

        $barangBaru = Barang::findOrFail($request->barang_id);

        if($request->jumlah > $barangBaru->stok){
            return back()->with('error','Stok tidak mencukupi.');
        }

        $barangKeluar->update([
            'barang_id' => $request->barang_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        $barangBaru->stok -= $request->jumlah;
        $barangBaru->save();

        return redirect()->route('barang-keluar.index')
            ->with('success','Data berhasil diupdate.');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $barang = Barang::findOrFail($barangKeluar->barang_id);
        $barang->stok += $barangKeluar->jumlah;
        $barang->save();
        $barangKeluar->delete();

            return redirect()->route('barang_keluar.index')
                ->with('success','Data berhasil dihapus.');
    }
    
}
