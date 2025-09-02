<?php

namespace App\Http\Controllers\WarehouseController;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\CsTruck;

class WarehouseController extends Controller
{
    public function dashboard()
    {
        // Ambil semua data truck hari ini
        $checks = CsTruck::whereDate('created_at', today())
            ->orderBy('created_at', 'asc') // terbaru di atas
            ->get(); 

        return view('warehouse.dashboard', compact('checks'));
    }

    public function updateLoadingStatus(Request $request, $checkId)
    {
        $request->validate([
            'loading_status' => 'required|in:loading,finish',
            'loading_dock' => 'required|string',
            'remarks' => 'nullable|string|max:255'
        ]);

        $csTruck = CsTruck::find($checkId);

        if ($csTruck) {
            $csTruck->update([
                'loading_dock' => $request->loading_dock,
                'status_process' => $request->loading_status,
                'remarks' => $request->remarks
            ]);
        }

        return back()->with('success', 'Data loading berhasil diperbarui.');
    }
}
