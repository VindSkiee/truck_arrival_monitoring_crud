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

        // Tentukan status security dengan ketentuan:
        // - Pass jika cargo_weight <= tolerance_weight DAN cargo_weight > 130% dari empty_weight
        // - Selain itu, Periksa
        $statusSecurity = 'Periksa';
        if ($csTruck) {
            $withinTolerance = (float) $request->cargo_weight <= (float) $csTruck->tolerance_weight;
            $aboveThirtyPercentOfEmpty = (float) $request->cargo_weight > ((float) $request->empty_weight * 1.3);
            if ($withinTolerance && $aboveThirtyPercentOfEmpty) {
                $statusSecurity = 'Pass';
            }
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
