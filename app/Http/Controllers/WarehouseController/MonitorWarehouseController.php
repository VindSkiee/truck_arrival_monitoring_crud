<?php

namespace App\Http\Controllers\WarehouseController;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\CsTruck;

class MonitorWarehouseController extends Controller
{
    // Halaman dashboard
    public function index()
    {
        return view('warehouse.monitor');
    }

    // Fetch data JSON untuk AJAX
    public function fetchData()
    {
        $checks = CsTruck::select('loading_dock', 'arrival_number', 'no_truck', 'status_process')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($checks);
    }
}
