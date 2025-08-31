<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Data Truck</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 5px; }
        th { background-color: #f2f2f2; text-align: center; }
        .truck-header { background-color: #e6f2ff; padding: 10px; margin-bottom: 10px; }
        .text-center { text-align: center; }
        .status-badge { 
            padding: 3px 8px; 
            border-radius: 12px; 
            font-size: 10px; 
            display: inline-block;
        }
        .bg-green-100 { background-color: #dcfce7; }
        .text-green-800 { color: #166534; }
        .bg-yellow-100 { background-color: #fef9c3; }
        .text-yellow-800 { color: #854d0e; }
        .bg-blue-100 { background-color: #dbeafe; }
        .text-blue-800 { color: #1e40af; }
        .bg-green-200 { background-color: #bbf7d0; }
        .bg-red-200 { background-color: #fecaca; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA TRUCK</h1>
        <p>Periode: {{ request('start_date') ?: 'Semua' }} - {{ request('end_date') ?: 'Data' }}</p>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    @foreach($trucks as $truck)
        <div style="margin-bottom: 20px; page-break-inside: avoid;">
            <div class="truck-header">
                <strong>TRUCK - {{ $truck->arrival_number }}</strong> | 
                Tanggal: {{ $truck->date }} | 
                Status: <span class="status-badge 
                    @if ($truck->status_process == 'finish') bg-green-100 text-green-800
                    @elseif($truck->status_process == 'loading') bg-yellow-100 text-yellow-800
                    @else bg-blue-100 text-blue-800 @endif">
                    {{ $truck->status_process ?? '-' }}
                </span>
            </div>

            <table>
                <tr>
                    <td width="16%"><strong>Kedatangan truck:</strong><br>{{ $truck->arrival_number ?? '-' }}</td>
                    <td width="16%"><strong>Qty box pallet:</strong><br>{{ $truck->total_qty_box ?? '-' }}</td>
                    <td width="16%"><strong>Berat total (kg):</strong><br>{{ $truck->total_material_weight ?? '-' }}</td>
                    <td width="16%"><strong>Berat box (kg):</strong><br>{{ $truck->total_box_weight ?? '-' }}</td>
                    <td width="16%"><strong>Berat isi (kg):</strong><br>{{ $truck->total_load_weight ?? '-' }}</td>
                    <td width="20%"><strong>No Truck:</strong><br>{{ $truck->no_truck ?? '-' }}</td>
                </tr>
            </table>

            @if($truck->items && count($truck->items) > 0)
                <h4 style="margin: 10px 0 5px 0;">Items:</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Area</th>
                            <th>No SO</th>
                            <th>Type</th>
                            <th>Qty Box</th>
                            <th>Status</th>
                            <th>Material Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($truck->items as $item)
                            <tr>
                                <td>{{ $item->nama_customer }}</td>
                                <td class="text-center">{{ $item->area }}</td>
                                <td class="text-center">{{ $item->no_so }}</td>
                                <td class="text-center">{{ $item->type }}</td>
                                <td class="text-center">{{ $item->qty_box }}</td>
                                <td class="text-center status-badge {{ $item->status_stock === 'Stock Ready' ? 'bg-green-200' : 'bg-red-200' }}">
                                    {{ $item->status_stock }}
                                </td>
                                <td class="text-center">{{ $item->material_weight }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endforeach
</body>
</html>