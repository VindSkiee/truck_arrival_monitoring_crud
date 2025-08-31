<?php

namespace App\Http\Controllers\csItemController;

use App\Models\CsTruck;
use App\Models\CsItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class itemController extends Controller
{

    public function addItemToTruck(Request $request, $truckId)
    {
        $truck = CsTruck::findOrFail($truckId);

        $item = CsItem::create([
            'truck_id' => $truck->id,
            'kedatangan_truck' => $request->no_kedatangan_truck,
            'nama_customer' => $request->nama_customer,
            'area' => $request->area,
            'urutan_bongkar' => $request->urutan_bongkar,
            'no_so' => $request->no_so,
            'mid' => $request->mid,
            'type' => $request->type,
            'item_weight' => $request->item_weight,
            'color' => $request->color,
            'pattern_nose' => $request->pattern_nose,
            'qty_box_pallet' => $request->qty_box_pallet,
            'qty_pcs' => $request->qty_pcs,
            'qty_box' => $request->qty_box,
            'status_stock' => $request->status_stock ?? 'Stock Ready',
            'waktu_muat' => $request->waktu_muat,
            'material_weight' => $request->material_weight,
            'box_weight' => $request->box_weight,
        ]);

        return redirect()->route('cs.dashboard')->with('success', 'Item berhasil ditambahkan ke truck');
    }

    public function editItem(Request $request, $id)
    {
        $request->validate([
            'nama_customer'    => 'required|string|max:100',
            'area'             => 'required|string|max:100',
            'urutan_bongkar'   => 'required|integer',
            'no_so'            => 'required|string|max:50',
            'mid'              => 'required|string|max:50',
            'type'             => 'required|string|max:50',
            'item_weight'      => 'required|numeric|min:0',
            'color'            => 'required|string|max:50',
            'pattern_nose'     => 'required|string|max:50',
            'qty_box_pallet'   => 'required|integer|min:0',
            'qty_pcs'          => 'required|integer|min:0',
            'qty_box'          => 'required|integer|min:0',
            'status_stock'     => 'nullable|string|max:50',
            'waktu_muat'       => 'required|string|max:50',
            'material_weight'  => 'required|numeric|min:0',
            'box_weight'       => 'required|numeric|min:0',
        ]);

        $item = CsItem::findOrFail($id);
        $item->update($request->only(['nama_customer', 'item_desc', 'qty']));

        return redirect()->back()->with('success', 'Item berhasil diupdate');
    }

    public function deleteItem($id)
    {
        $item = CsItem::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus');
    }

    public function history(Request $request)
    {
        $query = CsTruck::with('items')->orderBy('date', 'desc');

        // filter by tanggal
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $trucks = $query->get();

        return view('cs.history', compact('trucks'));
    }

    public function exportHistoryPdf(Request $request)
    {
        $query = CsTruck::with('items')->orderBy('date', 'desc');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $truck = $query->first();


        $pdf = Pdf::loadView('cs.history-pdf', compact('truck'));
        return $pdf->download('laporan-truck-' . ($request->date ?? now()->toDateString()) . '.pdf');
    }
}
