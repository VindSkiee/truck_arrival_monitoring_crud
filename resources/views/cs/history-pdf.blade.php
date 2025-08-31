<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Truck</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .header p {
            font-size: 11px;
            margin: 0;
        }
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-grid td {
            border: 1px solid #555;
            padding: 6px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #444;
            padding: 5px;
            text-align: center;
        }
        th {
            background: #eaeaea;
            font-weight: bold;
        }
        .status-finish { background: #d4edda; color: #155724; font-weight: bold; }
        .status-loading { background: #fff3cd; color: #856404; font-weight: bold; }
        .status-process { background: #cce5ff; color: #004085; font-weight: bold; }
        .remarks {
            background: #fff8dc;
            font-size: 11px;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Truck</h1>
        <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <!-- Info Truck -->
    <table class="info-grid">
        <tr>
            <td>Kedatangan Truck</td>
            <td>{{ $truck->arrival_number ?? '-' }}</td>
            <td>Qty Box/Pallet</td>
            <td>{{ number_format($truck->total_qty_box ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <span class="
                    @if ($truck->status_process == 'finish') status-finish
                    @elseif($truck->status_process == 'loading') status-loading
                    @else status-process @endif
                ">
                    {{ $truck->status_process ?? '-' }}
                </span>
            </td>
            <td>Berat Total (kg)</td>
            <td>{{ number_format($truck->total_material_weight ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Berat Box (kg)</td>
            <td>{{ number_format($truck->total_box_weight ?? 0, 0, ',', '.') }}</td>
            <td>Berat Isi Truck (kg)</td>
            <td>{{ number_format($truck->total_load_weight ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Min</td>
            <td>{{ number_format($truck->min_weight ?? 0, 0, ',', '.') }}</td>
            <td>Max</td>
            <td>{{ number_format($truck->max_weight ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Toleransi</td>
            <td>{{ number_format($truck->tolerance_weight ?? 0, 0, ',', '.') }}</td>
            <td>Warning</td>
            <td>{{ number_format($truck->warning_weight ?? 0, 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Items Table -->
    @if ($truck->items && count($truck->items) > 0)
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Kedatangan</th>
                    <th rowspan="2">Customer</th>
                    <th rowspan="2">Area</th>
                    <th rowspan="2">Urutan</th>
                    <th rowspan="2">No SO</th>
                    <th rowspan="2">MID</th>
                    <th colspan="4">Item Desc</th>
                    <th rowspan="2">Qty (Box/Pallet)</th>
                    <th rowspan="2">Qty/PCS</th>
                    <th rowspan="2">Qty Box/Pallet</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2">Waktu Muat</th>
                    <th rowspan="2">Berat Box</th>
                    <th rowspan="2">Berat Total</th>
                </tr>
                <tr>
                    <th>Type</th>
                    <th>Item Weight</th>
                    <th>Color</th>
                    <th>Pattern Nose</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($truck->items as $item)
                    <tr>
                        <td>{{ $item->kedatangan_truck }}</td>
                        <td>{{ $item->nama_customer }}</td>
                        <td>{{ $item->area }}</td>
                        <td>{{ $item->urutan_bongkar }}</td>
                        <td>{{ $item->no_so }}</td>
                        <td>{{ $item->mid }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ number_format($item->item_weight, 0, ',', '.') }}</td>
                        <td>{{ $item->color }}</td>
                        <td>{{ $item->pattern_nose }}</td>
                        <td>{{ number_format($item->qty_box_pallet, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->qty_pcs, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->qty_box, 0, ',', '.') }}</td>
                        <td>{{ $item->status_stock }}</td>
                        <td>{{ $item->waktu_muat }}</td>
                        <td>{{ number_format($item->box_weight, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->material_weight, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                @if (!empty($truck->remarks))
                    <tr>
                        <td colspan="17" class="remarks">
                            <strong>Remarks:</strong> {{ $truck->remarks }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    @else
        <p style="text-align:center; font-style:italic;">Tidak ada item untuk truck ini</p>
    @endif

</body>
</html>
