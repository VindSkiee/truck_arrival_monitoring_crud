<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsTruck extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional, karena sudah sesuai konvensi).
     */
    protected $table = 'cs_trucks';

    /**
     * Kolom yang bisa diisi (mass assignable).
     */
    protected $fillable = [
        'date',
        'arrival_number',
        'no_truck',
        'loading_dock',
        'empty_weight',
        'cargo_weight',
        'arrival_time',
        'total_qty_box',
        'total_qty_pcs',
        'total_items_weight',
        'total_material_weight',
        'total_box_weight',
        'total_load_weight',
        'status_process',
        'status_security',
    ];

    /**
     * Kolom yang dianggap bertipe date/datetime.
     */
    protected $casts = [
        'date' => 'date',
        'arrival_time' => 'datetime',
        'total_material_weight' => 'decimal:3',
        'total_box_weight' => 'decimal:3',
        'total_load_weight' => 'decimal:3',
        'min_weight' => 'decimal:3',
        'max_weight' => 'decimal:3',
        'tolerance_weight' => 'decimal:3',
        'warning_weight' => 'decimal:3',
    ];
}
