<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsTruck extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'arrival_date',
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
        'min_weight',
        'max_weight',
        'tolerance_weight',
        'warning_weight',
        'total_load_weight',
        'status_process',
        'status_security',
        'remarks',
    ];

    public function items()
    {
        return $this->hasMany(CsItem::class, 'truck_id');
    }

    public function recalcTotals()
    {
        $this->total_qty_box = $this->items()->sum('qty_box');
        $this->total_qty_pcs = $this->items()->sum('qty_pcs');
        $this->total_items_weight = $this->items()->sum('item_weight');

        $this->total_material_weight = $this->items()->sum('material_weight');
        $this->total_box_weight = $this->items()->sum('box_weight');

        // total isi truck = material + box
        $this->total_load_weight = $this->total_material_weight + $this->total_box_weight;

        $this->save();
    }
}
