<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsTruck extends Model
{
    use HasFactory;

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
        'min_weight',
        'max_weight',
        'tolerance_weight',
        'warning_weight',
        'total_load_weight',
        'status_process',
        'status_security',
    ];

    public function items()
    {
        return $this->hasMany(CsItem::class, 'truck_id');
    }
}
