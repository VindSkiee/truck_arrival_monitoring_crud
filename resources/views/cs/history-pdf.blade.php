<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Truck</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .info {
            margin-bottom: 15px;
        }
        .info table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info td {
            padding: 5px;
            font-size: 12px;
        }
        .table-container {
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th, td {
            padding: 6px;
            text-align: center;
        }
        th {
            background: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Truck</h1>
        <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>No. Kedatangan</strong></td>
                <td>{{ $truck->arrival_number }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td>{{ \Carbon\Carbon::parse($truck->date)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td><strong>Customer</strong></td>
                <td>{{ $truck->customer_name }}</td>
            </tr>
            <tr>
                <td><strong>Area</strong></td>
                <td>{{ $truck->area }}</td>
            </tr>
        </table>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No SO</th>
                    <th>Item Desc</th>
                    <th>Color</th>
                    <th>Pattern Nose</th>
                    <th>Qty/(Box/Pallet)</th>
                    <th>Qty/Pcs</th>
                    <th>Qty Box/Pallet</th>
                    <th>Berat Total (Kg)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($truck->items as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->no_so }}</td>
                    <td>{{ $item->item_desc }}</td>
                    <td>{{ $item->color }}</td>
                    <td>{{ $item->pattern_nose }}</td>
                    <td>{{ $item->qty_box_pallet }}</td>
                    <td>{{ $item->qty_pcs }}</td>
                    <td>{{ $item->qty_box }}</td>
                    <td>{{ $item->berat_total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
