<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Truck - {{ $truck->arrival_number ?? 'N/A' }}</title>
    <style>
        /* Global Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
        }
        
        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2c3e50;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            text-transform: uppercase;
        }
        
        .header p {
            font-size: 11px;
            margin: 3px 0;
            color: #7f8c8d;
        }
        
        .header .subtitle {
            font-weight: bold;
            color: #34495e;
        }
        
        /* Info Grid Styles */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        
        .info-grid td {
            border: 1px solid #95a5a6;
            padding: 6px 8px;
            font-size: 10px;
        }
        
        .info-grid tr td:first-child {
            font-weight: bold;
            background-color: #f8f9fa;
            width: 15%;
        }
        
        .info-grid tr td:nth-child(2) {
            width: 20%;
        }
        
        .info-grid tr td:nth-child(3) {
            font-weight: bold;
            background-color: #f8f9fa;
            width: 15%;
        }
        
        .info-grid tr td:nth-child(4) {
            width: 20%;
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            page-break-inside: auto;
        }
        
        th, td {
            border: 1px solid #bdc3c7;
            padding: 5px 4px;
            text-align: center;
            vertical-align: middle;
        }
        
        th {
            background: #34495e;
            color: white;
            font-weight: bold;
            padding: 7px 4px;
            font-size: 9px;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        /* Status Styles */
        .status-finish { 
            background: #d4edda; 
            color: #155724; 
            font-weight: bold;
            padding: 3px 6px;
            border-radius: 3px;
            display: inline-block;
        }
        
        .status-loading { 
            background: #fff3cd; 
            color: #856404; 
            font-weight: bold;
            padding: 3px 6px;
            border-radius: 3px;
            display: inline-block;
        }
        
        .status-process { 
            background: #cce5ff; 
            color: #004085; 
            font-weight: bold;
            padding: 3px 6px;
            border-radius: 3px;
            display: inline-block;
        }
        
        /* Remarks */
        .remarks {
            background: #fff8dc;
            font-size: 10px;
            padding: 8px;
            text-align: left;
            border: 1px solid #ffeaa7;
            margin-top: 15px;
            border-radius: 4px;
        }
        
        .remarks strong {
            color: #d35400;
        }
        
        /* Footer */
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #bdc3c7;
            text-align: center;
            font-size: 9px;
            color: #7f8c8d;
        }
        
        /* Utilities */
        .text-right {
            text-align: right;
        }
        
        .text-left {
            text-align: left;
        }
        
        .text-center {
            text-align: center;
        }
        
        .bold {
            font-weight: bold;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        /* Zebra striping for main table */
        tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }
        
        tbody tr:hover {
            background-color: #e9f7fe;
        }
        
        /* Column specific styles */
        td:nth-child(1), /* Kedatangan */
        td:nth-child(3), /* Area */
        td:nth-child(4), /* Urutan */
        td:nth-child(15), /* Status */
        td:nth-child(16) { /* Waktu Muat */
            font-size: 9px;
        }
        
        td:nth-child(11), /* Qty (Box/Pallet) */
        td:nth-child(12), /* Qty/PCS */
        td:nth-child(13), /* Qty Box/Pallet */
        td:nth-child(17), /* Berat Box */
        td:nth-child(18) { /* Berat Total */
            text-align: right;
            font-family: monospace;
        }
        
        /* Highlight important numbers */
        td.highlight {
            font-weight: bold;
            color: #c0392b;
        }
        
        @media print {
            body {
                padding: 10px;
                font-size: 10px;
            }
            
            .header {
                margin-bottom: 10px;
            }
            
            .info-grid, table {
                page-break-inside: avoid;
            }
            
            tbody {
                page-break-inside: avoid;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            .no-print {
                display: none;
            }
            
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Truck - {{ $truck->no_truck }}</h1>
        <p class="subtitle">PT. PAPERTECH INDONESIA</p>
        {{-- <p>Jl. Contoh Alamat No. 123, Kota Contoh</p>
        <p>Telp: (021) 123-4567 | Email: info@contoh.com</p> --}}
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <!-- Info Truck -->
    <table class="info-grid">
        <tr>
            <td>Kedatangan Truck</td>
            <td>{{ $truck->arrival_number ?? '-' }}</td>
            <td>Qty Box/Pallet</td>
            <td class="highlight">{{ number_format($truck->total_qty_box ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <span class="
                    @if ($truck->status_process == 'finish') status-finish
                    @elseif($truck->status_process == 'loading') status-loading
                    @else status-process @endif
                ">
                    {{ ucfirst($truck->status_process ?? '-') }}
                </span>
            </td>
            <td>Berat Total (kg)</td>
            <td class="highlight">{{ number_format($truck->total_material_weight ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Berat Box (kg)</td>
            <td>{{ number_format($truck->total_box_weight ?? 0, 0, ',', '.') }}</td>
            <td>Berat Isi Truck (kg)</td>
            <td class="highlight">{{ number_format($truck->total_load_weight ?? 0, 0, ',', '.') }}</td>
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
                        
                        <td class="text-left">{{ $item->nama_customer }}</td>
                        <td>{{ $item->area }}</td>
                        <td>{{ $item->urutan_bongkar }}</td>
                        <td>{{ $item->no_so }}</td>
                        <td>{{ $item->mid }}</td>
                        <td>{{ $item->type }}</td>
                        <td class="text-right">{{ number_format($item->item_weight, 0, ',', '.') }}</td>
                        <td>{{ $item->color }}</td>
                        <td>{{ $item->pattern_nose }}</td> <!-- Data Kolom Baru -->
                        <td class="text-right">{{ number_format($item->qty_box_pallet, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->qty_pcs, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->qty_box, 0, ',', '.') }}</td>
                        <td>{{ $item->status_stock }}</td>
                        <td>{{ $item->waktu_muat }}</td>
                        <td class="text-right">{{ number_format($item->box_weight, 0, ',', '.') }}</td>
                        <td class="text-right highlight">{{ number_format($item->material_weight, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        @if (!empty($truck->remarks))
            <div class="remarks">
                <strong>Catatan:</strong> {{ $truck->remarks }}
            </div>
        @endif
        
        <!-- Summary Section -->
        <div style="margin-top: 15px; padding: 10px; background: #f8f9fa; border-radius: 4px;">
            <table style="border: none;">
                <tr>
                    <td style="border: none; text-align: right; font-weight: bold;">Total Qty Box/Pallet:</td>
                    <td style="border: none; text-align: right; width: 15%;">{{ number_format($truck->total_qty_box ?? 0, 0, ',', '.') }} kg</td>
                    <td style="border: none; width: 5%;"></td>
                    <td style="border: none; text-align: right; font-weight: bold;">Total Berat Material:</td>
                    <td style="border: none; text-align: right; width: 15%;">{{ number_format($truck->total_material_weight ?? 0, 0, ',', '.') }} kg</td>
                </tr>
                <tr>
                    <td style="border: none; text-align: right; font-weight: bold;">Total Berat Box:</td>
                    <td style="border: none; text-align: right;">{{ number_format($truck->total_box_weight ?? 0, 0, ',', '.') }} kg</td>
                    <td style="border: none;"></td>
                    <td style="border: none; text-align: right; font-weight: bold;">Total Berat Muatan:</td>
                    <td style="border: none; text-align: right;">{{ number_format($truck->total_load_weight ?? 0, 0, ',', '.') }} kg</td>
                </tr>
            </table>
        </div>
    @else
        <p style="text-align:center; font-style:italic; padding: 20px; border: 1px dashed #ccc; margin-top: 20px;">
            Tidak ada item untuk truck ini
        </p>
    @endif

    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->name ?? 'System' }} pada {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p>Halaman 1 dari 1</p>
    </div>

</body>
</html>