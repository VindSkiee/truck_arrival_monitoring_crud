<?php

namespace App\Http\Controllers\csTruckController;

use App\Models\CsTruck;
use App\Models\CsItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class truckController extends Controller
{
    // 1. Buat truck baru saat kedatangan
    public function createTruck(Request $request)
    {
        $validated = $request->validate([
        'arrival_number' => 'required|integer',
        'date'   => 'required|date',
    ]);

    $truck = CsTruck::create([
        'arrival_number' => $validated['arrival_number'],
        'date' => $validated['date'],
    ]);


        return redirect()->route('cs.dashboard')->with('success', 'Truck berhasil ditambahkan');
    }

    // 3. Lihat detail truck beserta items
    public function getTruck($truckId)
    {
        $truck = CsTruck::whereDate('date', today())->with('items')->findOrFail($truckId);

        return response()->json($truck);
    }

    public function dashboard()
    {
        $trucks = \App\Models\CsTruck::with('items')->get();
        return view('cs.dashboard', compact('trucks'), [
            'kedatangan_trucks' => \App\Models\CsItem::select('kedatangan_truck')->distinct()->pluck('kedatangan_truck'),
            'customers' => \App\Models\CsItem::select('nama_customer')->distinct()->pluck('nama_customer'),
            'areas' => \App\Models\CsItem::select('area')->distinct()->pluck('area'),
            'urutan_bongkars' => \App\Models\CsItem::select('urutan_bongkar')->distinct()->pluck('urutan_bongkar'),
            'no_sos' => \App\Models\CsItem::select('no_so')->distinct()->pluck('no_so'),
            'mids' => \App\Models\CsItem::select('mid')->distinct()->pluck('mid'),
            'types' => \App\Models\CsItem::select('type')->distinct()->pluck('type'),
            'colors' => \App\Models\CsItem::select('color')->distinct()->pluck('color'),
            'pattern_noses' => \App\Models\CsItem::select('pattern_nose')->distinct()->pluck('pattern_nose'),
            'waktu_muats' => \App\Models\CsItem::select('waktu_muat')->distinct()->pluck('waktu_muat'),
        ]);
    }

    public function deleteTruck($truckId)
    {
        $truck = CsTruck::with('items')->findOrFail($truckId);
        $truck->delete();

        return redirect()->route('cs.dashboard')->with('success', 'Truck berhasil dihapus');
    }

}
