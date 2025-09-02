<?php

namespace App\Http\Controllers\SecurityController;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\CsTruck;

class SecurityController extends Controller
{
    // Dashboard security menampilkan semua truck hari ini
    public function dashboard()
    {
        $checks = CsTruck::whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('security.dashboard', compact('checks'));
    }

    // Update kolom yang diinput oleh security
    public function updateTruckData(Request $request, $checkId)
    {
        $request->validate([
            'no_truck' => 'required|string|max:20',
            'empty_weight' => 'required|numeric|min:0',
            'cargo_weight' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255'
        ]);

        $csTruck = CsTruck::find($checkId);

        $statusSecurity = ($request->cargo_weight <= $csTruck->tolerance_weight) ? 'Pass' : 'Periksa';
        if ($csTruck) {
            $csTruck->update([
                'no_truck' => $request->no_truck,
                'empty_weight' => $request->empty_weight,
                'cargo_weight' => $request->cargo_weight,
                'remarks' => $request->remarks,
                'status_security' => $statusSecurity
            ]);
        }

        return back()->with('success', 'Data truck berhasil diperbarui.');
    }
}
