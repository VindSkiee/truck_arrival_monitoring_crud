<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsItem extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional, Laravel otomatis pakai cs_items).
     */
    protected $table = 'cs_items';

    /**
     * Kolom yang bisa diisi mass assignment.
     */
    protected $fillable = [
        'kedatangan_truck',
        'nama_customer',
        'area',
        'urutan_bongkar',
        'no_so',
        'mid',
        'type',
        'item_weight',
        'color',
        'pattern_nose',
        'qty_box_pallet',
        'qty_pcs',
        'qty_box',
        'status_stock',
        'waktu_muat',
        'material_weight',
        'box_weight',
    ];

    /**
     * Casting tipe data otomatis.
     */
    protected $casts = [
        'kedatangan_truck' => 'datetime',
        'item_weight' => 'decimal:2',
        'material_weight' => 'decimal:2',
        'box_weight' => 'decimal:2',
        'urutan_bongkar' => 'integer',
        'qty_box_pallet' => 'integer',
        'qty_pcs' => 'integer',
        'qty_box' => 'integer',
    ];
}
