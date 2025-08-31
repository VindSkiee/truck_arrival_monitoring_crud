<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History - CS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .compact-table {
            font-size: 0.7rem;
        }

        .compact-table th,
        .compact-table td {
            padding: 0.25rem 0.4rem;
        }

        .truck-card {
            transition: all 0.3s ease;
        }

        .truck-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .truck-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 12px;
            justify-items: center;
            align-items: center;
        }

        .status-badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
        }

        .navbar {
            background-color: #1E3A8A;
        }

        .logo-container {
            height: 2rem;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="navbar text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <div class="logo-container mr-3 bg-white rounded p-1 flex items-center justify-center">
                    <span class="text-blue-800 font-bold text-lg">S</span>
                </div>
                <h1 class="text-xl font-bold">SONOCO</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('cs.dashboard') }}" class="hover:text-gray-300">
                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                </a>
                <a href="#" class="hover:text-gray-300">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">History Truck & Items</h1>

        <!-- Filter -->
        <form method="GET" action="{{ route('cs.history') }}" class="flex items-end gap-3 mb-6">
            <div>
                <label class="block text-sm font-medium">Filter Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" class="border rounded p-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded">Cari</button>

            @if (request('date'))
                <a href="{{ route('cs.history.pdf', ['date' => request('date')]) }}"
                    class="bg-green-600 text-white px-3 py-2 rounded" target="_blank">
                    Cetak PDF
                </a>
            @endif
        </form>

        <!-- Data Trucks -->
        @forelse ($trucks as $truck)
            <div class="border rounded-lg shadow mb-6">
                <div class="bg-gray-100 px-4 py-2 flex justify-between items-center">
                    <h2 class="font-semibold">Truck #{{ $truck->id }} - Kedatangan: {{ $truck->arrival_number }}</h2>
                    <span class="text-sm text-gray-600">Tanggal: {{ $truck->date }}</span>
                </div>

                <div class="p-4">
                    <!-- Truck Info -->
                    <div class="grid grid-cols-5 gap-3 text-sm truck-info-grid mb-4">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 mb-1 font-bold">Kedatangan truck</span>
                            <span class="text-sm font-medium text-center">{{ $truck->arrival_number ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 mb-1 font-bold">Qty box pallet</span>
                            <span class="text-sm font-medium text-center">{{ $truck->total_qty_box ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 mb-1 font-bold">Status</span>
                            <span
                                class="text-center px-2 py-1 rounded
                            @if ($truck->status_process == 'finish') bg-green-100 text-green-800
                            @elseif($truck->status_process == 'loading') bg-yellow-100 text-yellow-800
                            @else bg-blue-100 text-blue-800 @endif">
                                {{ $truck->status_process ?? '-' }}
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 mb-1 font-bold">Berat total (kg)</span>
                            <span
                                class="text-sm font-medium text-center">{{ $truck->total_material_weight ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 mb-1 font-bold">Berat isi (kg)</span>
                            <span class="text-sm font-medium text-center">{{ $truck->total_load_weight ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="overflow-x-auto text-xs">
                        <table class="w-full border-collapse border">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th rowspan="2" class="border p-1">Kedatangan</th>
                                    <th rowspan="2" class="border p-1">Customer</th>
                                    <th rowspan="2" class="border p-1">Area</th>
                                    <th rowspan="2" class="border p-1">Urutan</th>
                                    <th rowspan="2" class="border p-1">No SO</th>
                                    <th rowspan="2" class="border p-1">MID</th>
                                    <th colspan="4" class="border p-1 text-center">Item Desc</th>
                                    <th rowspan="2" class="border p-1">Box/Pallet</th>
                                    <th rowspan="2" class="border p-1">PCS</th>
                                    <th rowspan="2" class="border p-1">Box</th>
                                    <th rowspan="2" class="border p-1">Box Weight</th>
                                    <th rowspan="2" class="border p-1">Status</th>
                                    <th rowspan="2" class="border p-1">Waktu Muat</th>
                                    <th rowspan="2" class="border p-1">Material Weight</th>
                                </tr>
                                <tr class="bg-gray-100">
                                    <th class="border p-1">Type</th>
                                    <th class="border p-1">Item Weight</th>
                                    <th class="border p-1">Color</th>
                                    <th class="border p-1">Pattern Nose</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($truck->items as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-1">{{ $item->kedatangan_truck }}</td>
                                        <td class="border p-1">{{ $item->nama_customer }}</td>
                                        <td class="border p-1">{{ $item->area }}</td>
                                        <td class="border p-1">{{ $item->urutan_bongkar }}</td>
                                        <td class="border p-1">{{ $item->no_so }}</td>
                                        <td class="border p-1">{{ $item->mid }}</td>
                                        <td class="border p-1">{{ $item->type }}</td>
                                        <td class="border p-1">{{ $item->item_weight }}</td>
                                        <td class="border p-1">{{ $item->color }}</td>
                                        <td class="border p-1">{{ $item->pattern_nose }}</td>
                                        <td class="border p-1">{{ $item->qty_box_pallet }}</td>
                                        <td class="border p-1">{{ $item->qty_pcs }}</td>
                                        <td class="border p-1">{{ $item->qty_box }}</td>
                                        <td class="border p-1">{{ $item->box_weight }}</td>
                                        <td class="border p-1">{{ $item->status_stock }}</td>
                                        <td class="border p-1">{{ $item->waktu_muat }}</td>
                                        <td class="border p-1">{{ $item->material_weight }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="17" class="text-center text-gray-500 p-2">Tidak ada item</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada data history.</p>
        @endforelse
    </div>
</body>

</html>
