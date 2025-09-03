<?php

namespace App\Http\Controllers\csTruckController;

use App\Models\CsTruck;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class truckController extends Controller
{
    public function createTruck(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);
    
        // Ambil nomor kedatangan terakhir di tanggal yang sama
        $lastTruck = CsTruck::where('date', $request->date)
            ->orderBy('arrival_number', 'desc')
            ->first();
    
        $nextArrivalNumber = $lastTruck ? $lastTruck->arrival_number + 1 : 1;
    
        CsTruck::create([
            'arrival_number' => $nextArrivalNumber,
            'date' => $request->date,
            // tambahkan field lain jika perlu
        ]);
    
        return redirect()->back()->with('success', 'Pengiriman berhasil ditambahkan!');
    }
    // 3. Lihat detail truck beserta items
    public function getTruck($truckId)
    {
        $truck = CsTruck::whereDate('date', today())->with('items')->findOrFail($truckId);

        return response()->json($truck);
    }

    public function dashboard()
    {
        $trucks = \App\Models\CsTruck::whereDate('date', today())->with('items')->get();
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
