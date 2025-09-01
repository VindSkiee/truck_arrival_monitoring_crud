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
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-gray-300">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </button>
                </form>
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

            @if ($trucks && $trucks->count() > 0)
                <a href="{{ route('cs.history.pdf', ['date' => $date]) }}"
                    class="bg-green-600 text-white px-3 py-2 rounded" target="_blank">
                    Cetak PDF
                </a>
            @endif
        </form>

        <!-- Data Trucks -->
        @forelse ($trucks as $truck)
            <div class="border rounded-lg shadow mb-6">
                <div class="bg-gray-100 px-4 py-2 flex justify-between items-center">
                    <h2 class="font-semibold">Truck - Kedatangan: {{ $truck->arrival_number }}</h2>
                    <span class="text-sm text-gray-600">Tanggal: {{ $truck->date }}</span>
                </div>

                <div class="p-4">
                    <!-- Truck Info -->
                    <div class="p-4 border-b">
                        <div class="truck-info-grid mb-3">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-3 font-bold">Kedatangan truck</span>
                                <span class="text-sm font-medium text-center">{{ $truck->arrival_number ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-3 font-bold">Qty box / pallet</span>
                                <span
                                    class="text-sm font-medium text-center">{{ number_format($truck->total_qty_box ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-3 font-bold">Status</span>
                                <span
                                    class="status-badge text-center
                                            @if ($truck->status_process == 'finish') bg-green-100 text-green-800
                                            @elseif($truck->status_process == 'loading') bg-yellow-100 text-yellow-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                    {{ $truck->status_process ?? '-' }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-3 font-bold">BERAT TOTAL (kg)</span>
                                <span
                                    class="text-sm font-medium text-center">{{ number_format($truck->total_material_weight ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-3 font-bold">BERAT BOX (kg)</span>
                                <span
                                    class="text-sm font-medium text-center">{{ number_format($truck->total_box_weight ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-3 font-bold">BERAT ISI TRUCK (kg)</span>
                                <span
                                    class="text-sm font-medium text-center">{{ number_format($truck->total_load_weight ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-3 font-bold">MIN</span>
                                <span
                                    class="text-sm font-medium text-center">{{ number_format($truck->min_weight ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-3 font-bold">MAX</span>
                                <span
                                    class="text-sm font-medium text-center">{{ number_format($truck->max_weight ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-yellow-500 mb-3 font-bold">TOLERANSI</span>
                                <span
                                    class="text-sm font-medium text-center">{{ number_format($truck->tolerance_weight ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-red-500 mb-3 font-bold">WARNING</span>
                                <span
                                    class="text-sm font-medium text-center">{{ number_format($truck->warning_weight ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="p-3 overflow-x-auto">
                            @if ($truck->items && count($truck->items) > 0)
                                <table class="w-full border-collapse border compact-table">
                                    <thead>
                                        <!-- Row 1: grup header -->
                                        <tr class="bg-gradient-to-r from-blue-200 to-blue-50 text-gray-800">
                                            <th class="border p-1 text-center" rowspan="2">Kedatangan</th>
                                            <th class="border p-1 text-center" rowspan="2">Customer</th>
                                            <th class="border p-1 text-center" rowspan="2">Area</th>
                                            <th class="border p-1 text-center" rowspan="2">Urutan</th>
                                            <th class="border p-1 text-center" rowspan="2">No SO</th>
                                            <th class="border p-1 text-center" rowspan="2">MID</th>

                                            <!-- Grup Item Desc -->
                                            <th class="border p-1 text-center" colspan="4">Item Desc</th>
                                            <th class="border p-1 text-center" rowspan="2">Qty (Box/Pallet)</th>
                                            <th class="border p-1 text-center" rowspan="2">Qty/PCS</th>
                                            <th class="border p-1 text-center" rowspan="2">Qty box/pallet</th>
                                            <th class="border p-1 text-center" rowspan="2">Status</th>
                                            <th class="border p-1 text-center" rowspan="2">Waktu Muat</th>
                                            <th class="border p-1 text-center" rowspan="2">BERAT box</th>
                                            <th class="border p-1 text-center" rowspan="2">BERAT TOTAL</th>
                                            <th class="border p-1 text-center" rowspan="2">Aksi</th>
                                        </tr>

                                        <!-- Row 2: sub kolom detail -->
                                        <tr class="bg-gradient-to-r from-blue-300 to-blue-100 text-gray-700">
                                            <th class="border p-1 text-center">Type</th>
                                            <th class="border p-1 text-center">Item Weight</th>
                                            <th class="border p-1 text-center">Color</th>
                                            <th class="border p-1 text-center">Pattern Nose</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($truck->items as $item)
                                            <tr class="hover:bg-gray-50">
                                                <td class="border p-1 text-center">{{ $item->kedatangan_truck }}</td>
                                                <td class="border p-1 text-center">{{ $item->nama_customer }}</td>
                                                <td class="border p-1 text-center">{{ $item->area }}</td>
                                                <td class="border p-1 text-center">{{ $item->urutan_bongkar }}</td>
                                                <td class="border p-1 text-center">{{ $item->no_so }}</td>
                                                <td class="border p-1 text-center">{{ $item->mid }}</td>

                                                <!-- Item Desc -->
                                                <td class="border p-1 text-center">{{ $item->type }}</td>
                                                <td class="border p-1 text-center">
                                                    {{ number_format($item->item_weight, 0, ',', '.') }}</td>
                                                <td class="border p-1 text-center">{{ $item->color }}</td>
                                                <td class="border p-1 text-center">{{ $item->pattern_nose }}</td>

                                                <td class="border p-1 text-center">
                                                    {{ number_format($item->qty_box_pallet, 0, ',', '.') }}</td>
                                                <td class="border p-1 text-center">
                                                    {{ number_format($item->qty_pcs, 0, ',', '.') }}</td>
                                                <td class="border p-1 text-center">
                                                    {{ number_format($item->qty_box, 0, ',', '.') }}</td>

                                                <td
                                                    class="border p-1 text-center font-bold 
                {{ $item->status_stock === 'Stock Ready' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                    {{ $item->status_stock }}
                                                </td>

                                                <td class="border p-1 text-center">{{ $item->waktu_muat }}</td>
                                                <td class="border p-1 text-center">
                                                    {{ number_format($item->box_weight, 0, ',', '.') }}</td>
                                                <td class="border p-1 text-center">
                                                    {{ number_format($item->material_weight, 0, ',', '.') }}</td>
                                                <td class="border p-1 text-center">
                                                    <div class="flex justify-center space-x-1">
                                                        <button type="button"
                                                            class="text-blue-600 hover:text-blue-800 p-1"
                                                            onclick='openEditItemModal(@json($item))'>
                                                            <i class="fas fa-edit text-xs"></i>
                                                        </button>

                                                        <form action="{{ route('item.delete', $item->id) }}"
                                                            method="POST" style="display:inline;"
                                                            onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-red-600 hover:text-red-800 p-1">
                                                                <i class="fas fa-trash text-xs"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <!-- Tambahkan baris remarks -->
                                        @if (!empty($truck->remarks))
                                            <tr class="bg-yellow-50">
                                                <td class="border p-2 font-bold text-gray-700 text-left"
                                                    colspan="18">
                                                    Remarks: <span class="font-normal">{{ $truck->remarks }}</span>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>

                                </table>
                            @else
                                <div class="text-center py-4 text-gray-500">
                                    <i class="fas fa-box-open text-3xl mb-2"></i>
                                    <p>Tidak ada item untuk truck ini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty

                <div class="flex flex-col items-center justify-center py-10">
                    <i class="fas fa-truck text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600 text-center">Tidak ada truck di <b>Tanggal ini.</b></p>
                </div>

        @endforelse
    </div>

    <div id="editItemModal"
        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-3/4 lg:w-2/3 max-h-[90vh] overflow-y-auto">
            <div class="p-4 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Edit Item</h2>
            </div>
            <form method="POST" id="editItemForm" action="">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Customer</label>
                        <input type="text" name="nama_customer" id="edit_nama_customer"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">kedatangan</label>
                        <input type="text" name="kedatangan_truck" id="kedatangan_truck"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Area</label>
                        <input type="text" name="area" id="edit_area"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">No SO</label>
                        <input type="text" name="no_so" id="edit_no_so"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Urutan Bongkar</label>
                        <input type="text" name="urutan_bongkar" id="edit_urutan_bongkar"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">MID</label>
                        <input type="text" name="mid" id="edit_mid"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Type</label>
                        <input type="text" name="type" id="edit_type"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Item Weight</label>
                        <input type="number" step="0.01" name="item_weight" id="edit_item_weight"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Color</label>
                        <input type="text" name="color" id="edit_color"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Pattern Nose</label>
                        <input type="text" name="pattern_nose" id="edit_pattern_nose"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Qty (Box/Pallet)</label>
                        <input type="number" name="qty_box_pallet" id="edit_qty_box_pallet"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Qty/PCS</label>
                        <input type="number" name="qty_pcs" id="edit_qty_pcs"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Qty Box / pallet</label>
                        <input type="number" name="qty_box" id="edit_qty_box"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status Stock</label>
                        <select name="status_stock" id="edit_status_stock" class="border rounded p-2 w-full text-sm">
                            <option value="Stock Ready">Stock Ready</option>
                            <option value="On Production">On Production</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Waktu Muat</label>
                        <input type="text" name="waktu_muat" id="edit_waktu_muat"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">BERAT TOTAL (kg)</label>
                        <input type="number" step="0.01" name="material_weight" id="edit_material_weight"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">BERAT box (kg)</label>
                        <input type="number" step="0.01" name="box_weight" id="edit_box_weight"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                </div>
                <div class="p-4 flex justify-end space-x-3 border-t">
                    <button type="button" onclick="closeEditItemModal()"
                        class="px-4 py-2 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded text-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Close modal when clicking outside
        document.getElementById('itemModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeItemModal();
            }
        });

        function openEditItemModal(item) {
            const modal = document.getElementById('editItemModal');
            const form = document.getElementById('editItemForm');

            form.action = `/item/${item.id}`;

            document.getElementById('edit_nama_customer').value = item.nama_customer ?? '';
            document.getElementById('kedatangan_truck').value = item.kedatangan_truck ?? '';
            document.getElementById('edit_area').value = item.area ?? '';
            document.getElementById('edit_no_so').value = item.no_so ?? '';
            document.getElementById('edit_urutan_bongkar').value = item.urutan_bongkar ?? '';
            document.getElementById('edit_mid').value = item.mid ?? '';
            document.getElementById('edit_type').value = item.type ?? '';
            document.getElementById('edit_item_weight').value = item.item_weight ?? '';
            document.getElementById('edit_color').value = item.color ?? '';
            document.getElementById('edit_pattern_nose').value = item.pattern_nose ?? '';
            document.getElementById('edit_qty_box_pallet').value = item.qty_box_pallet ?? '';
            document.getElementById('edit_qty_pcs').value = item.qty_pcs ?? '';
            document.getElementById('edit_qty_box').value = item.qty_box ?? '';
            document.getElementById('edit_box_weight').value = item.box_weight ?? '';
            document.getElementById('edit_status_stock').value = item.status_stock ?? '';
            document.getElementById('edit_waktu_muat').value = item.waktu_muat ?? '';
            document.getElementById('edit_material_weight').value = item.material_weight ?? '';

            modal.classList.remove('hidden');
        }

        function closeEditItemModal() {
            document.getElementById('editItemModal').classList.add('hidden');
        }
    </script>
</body>

</html>
