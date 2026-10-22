<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'supplier_id',
        'stok',
        'satuan',
        'kebutuhan_harian',
        'lead_time',
        'safety_stock',
        'reorder_point',

    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
