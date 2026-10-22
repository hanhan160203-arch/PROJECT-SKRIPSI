<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();

        return view('supplier.index', compact('suppliers'));
    }

    /**s
     * Show the form for csreating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        \App\Models\Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            
        ]);

        return redirect()->route('supplier.index')
        ->with('success', 'Data Supplier berhasil ditambahkan.');
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
        $supplier = Supplier::findOrFail($id);

        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);

    $supplier->update([
        'nama_supplier' => $request->nama_supplier,
        'no_hp' => $request->no_hp,
        'email' => $request->email,
        'alamat' => $request->alamat,
    ]);

    return redirect()->route('supplier.index')
        ->with('success', 'Data Supplier berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Supplier::findOrFail($id)->delete();

    return redirect()->route('supplier.index')
        ->with('success', 'Data Supplier berhasil dihapus.');
    }
}
