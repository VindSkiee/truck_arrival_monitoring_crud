<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsItem extends Model
{
    use HasFactory;

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
        'truck_id',
    ];

    public function truck()
    {
        return $this->belongsTo(CsTruck::class, 'truck_id');
    }
}
