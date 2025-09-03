<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS Dashboard</title>
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
            /* horizontal center */
            align-items: center;
            /* vertical center */
        }

        .status-badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
        }

        .modal {
            transition: opacity 0.25s ease;
        }

        /* Navbar styling */
        .navbar {
            background-color: #1E3A8A;
            /* Biru gelap */
        }

        .logo-container {
            height: 2rem;
            /* Tinggi yang sama dengan teks */
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="navbar text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <!-- Logo placeholder - ganti dengan logo asli Sonoco -->
                <div class="logo-container mr-3 bg-white rounded p-1 flex items-center justify-center">
                    <img src="{{ asset('pics/Sonoco.png') }}" alt="Sonoco Logo" class="h-full">
                    <!-- Ganti dengan tag img jika memiliki logo -->
                    <!-- <img src="path-to-logo.png" alt="Sonoco Logo" class="h-full"> -->
                </div>
                <h1 class="text-xl font-bold">CS SONOCO</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('cs.history') }}" class="hover:text-gray-300">
                    <i class="fas fa-history mr-1"></i> History
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
    @if (session('success'))
        <div id="alert-box"
            class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-white-800 dark:text-green-400"
            role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Success!</span> {{ session('success') }}.
            </div>
        </div>
    @elseif(session('error'))
        <div id="alert-box"
            class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-white-800 dark:text-red-400"
            role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Danger!</span> {{ session('error') }}.
            </div>
        </div>
    @endif

    <div class="p-4">



        <!-- Reset Button -->


        <div class="max-w-full mx-auto">
            {{-- Form Tambah Truck --}}
            <form method="POST" action="{{ route('cs.addTruck') }}" class="flex items-center gap-3 bg-white p-2 rounded shadow w-full max-w-full">
            @csrf

            <label for="date" class="text-xs font-medium text-gray-600 whitespace-nowrap">Tanggal:</label>

            <input type="date" id="date" name="date"
                class="border rounded px-2 py-1 text-sm w-[150px]" required>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-sm flex items-center">
                <i class="fas fa-plus mr-1"></i> Tambah Pengiriman
            </button>
        </form>



            {{-- Trucks List --}}
            <div class="space-y-5 mt-5">
                <h2 class="text-lg font-semibold mb-3 text-gray-700 flex items-center">
                    <i class="fas fa-list mr-2"></i> Daftar Truck
                </h2>
                @if ($trucks->isEmpty())
                    <div class="flex flex-col items-center justify-center py-10">
                        <i class="fas fa-truck text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600 text-center">Belum ada truck yang ditambahkan <b>hari ini.</b></p>
                    </div>
                @else
                    <div class="flex justify-end mb-4">
                    </div>
                    @foreach ($trucks as $truck)
                        <div class="truck-card bg-white border rounded-lg shadow-sm overflow-hidden">
                            {{-- Truck Header --}}
                            <div
                                class="bg-gradient-to-r from-blue-50 to-gray-50 px-4 py-3 flex justify-between items-center flex-wrap border-b">
                                <div class="flex items-center">
                                    <h2 class="font-semibold text-gray-800">
                                        <i class="fas fa-truck mr-2"></i>PENGIRIMAN - {{ $truck->arrival_number }}
                                    </h2>
                                    @if ($truck->no_truck)
                                        <span
                                            class="ml-2 bg-gray-100 text-gray-800 text-xs font-medium px-2 py-0.5 rounded">
                                            No: {{ $truck->no_truck }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2 mt-2 md:mt-0">
                                    <span
                                        class="text-xs text-gray-600 font-bold">{{ \Carbon\Carbon::parse($truck->date)->translatedFormat('l, d F Y') }}</span>
                                    <button class="text-blue-600 hover:text-blue-800 text-sm p-1"
                                        onclick="openItemModal({{ $truck->id }})">
                                        <i class="fas fa-plus-circle"></i> Tambah Item
                                    </button>
                                    <form action="{{ route('truck.delete', $truck->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus truck ini?')"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm p-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Truck Information --}}
                            <div class="p-4 border-b">
                                <div class="truck-info-grid">
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-500 mb-3 font-bold">Kedatangan truck</span>
                                        <span
                                            class="text-sm font-medium text-center">{{ $truck->arrival_number ?? '-' }}</span>
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
                            </div>

                            {{-- Items Table --}}
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
                                                <th class="border p-1 text-center" rowspan="2">Qty (Box/Pallet)
                                                </th>
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
                                                    <td class="border p-1 text-center">{{ $item->kedatangan_truck }}
                                                    </td>
                                                    <td class="border p-1 text-center">{{ $item->nama_customer }}</td>
                                                    <td class="border p-1 text-center">{{ $item->area }}</td>
                                                    <td class="border p-1 text-center">{{ $item->urutan_bongkar }}
                                                    </td>
                                                    <td class="border p-1 text-center">{{ $item->no_so }}</td>
                                                    <td class="border p-1 text-center">{{ $item->mid }}</td>

                                                    <!-- Item Desc -->
                                                    <td class="border p-1 text-center">{{ $item->type }}</td>
                                                    <td class="border p-1 text-center">
                                                        {{ number_format($item->item_weight, 0, ',', '.') }}</td>
                                                    <td class="border p-1 text-center">{{ $item->color }}</td>
                                                    <td class="border p-1 text-center">{{ $item->pattern_nose }}</td>

                                                    <td class="border p-1 text-center">
                                                        {{ number_format($item->qty_box_pallet, 0, ',', '.') }}
                                                    </td>
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
                                                        {{ number_format($item->material_weight, 0, ',', '.') }}
                                                    </td>
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
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Form for Adding Items -->
    <div id="itemModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-3/4 lg:w-2/3 max-h-[90vh] overflow-y-auto">
            <div class="p-4 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Tambah Item Baru</h2>
            </div>
            <form method="POST" action="{{ route('cs.addItem', 'TRUCK_ID') }}" id="itemForm" class="p-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Kedatangan Truck</label>
                        <input type="text" name="kedatangan_truck" class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Customer</label>
                        <input type="text" name="nama_customer" list="customerList"
                            class="border rounded p-2 w-full text-sm" required>
                        <datalist id="customerList">
                            @foreach ($customers as $val)
                                <option value="{{ $val }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Area</label>
                        <input type="text" name="area" list="areaList"
                            class="border rounded p-2 w-full text-sm">
                        <datalist id="areaList">
                            @foreach ($areas as $val)
                                <option value="{{ $val }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Urutan Bongkar</label>
                        <input type="text" name="urutan_bongkar" class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">No SO</label>
                        <input type="text" name="no_so" class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">MID</label>
                        <input type="text" name="mid" class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Type</label>
                        <input type="text" name="type" list="typeList"
                            class="border rounded p-2 w-full text-sm">
                        <datalist id="typeList">
                            @foreach ($types as $val)
                                <option value="{{ $val }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Item Weight</label>
                        <input type="number" step="0.01" name="item_weight"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Color</label>
                        <input type="text" name="color" list="colorList"
                            class="border rounded p-2 w-full text-sm">
                        <datalist id="colorList">
                            @foreach ($colors as $val)
                                <option value="{{ $val }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Pattern Nose</label>
                        <input type="text" name="pattern_nose" list="patternNoseList"
                            class="border rounded p-2 w-full text-sm">
                        <datalist id="patternNoseList">
                            @foreach ($pattern_noses as $val)
                                <option value="{{ $val }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Qty (Box/Pallet)</label>
                        <input type="number" name="qty_box_pallet" class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Qty/PCS</label>
                        <input type="number" name="qty_pcs" class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Qty Box / pallet</label>
                        <input type="number" name="qty_box" class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status Stock</label>
                        <select name="status_stock" class="border rounded p-2 w-full text-sm">
                            <option value="Stock Ready">Stock Ready</option>
                            <option value="On Production">On Production</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Waktu Muat</label>
                        <input type="text" name="waktu_muat" list="waktuMuatList"
                            class="border rounded p-2 w-full text-sm">
                        <datalist id="waktuMuatList">
                            @foreach ($waktu_muats as $val)
                                <option value="{{ $val }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">BERAT box (kg)</label>
                        <input type="number" step="0.01" name="box_weight"
                            class="border rounded p-2 w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">BERAT TOTAL (kg)</label>
                        <input type="number" step="0.01" name="material_weight"
                            class="border rounded p-2 w-full text-sm">
                    </div>

                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeItemModal()"
                        class="px-4 py-2 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                        Simpan Item
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Form for Editing Item -->
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
        function openItemModal(truckId) {
            const modal = document.getElementById('itemModal');
            const form = document.getElementById('itemForm');
            form.action = form.action.replace('TRUCK_ID', truckId);
            modal.classList.remove('hidden');
        }

        function closeItemModal() {
            document.getElementById('itemModal').classList.add('hidden');
        }

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

        function resetDashboard() {
            const tableBody = document.querySelector("#table-dashboard tbody");
            tableBody.innerHTML = ""; // hapus semua baris tabel
        }

        // hilangkan alert setelah 3 detik
        setTimeout(() => {
            const alertBox = document.getElementById('alert-box');
            if (alertBox) {
                alertBox.style.transition = "opacity 0.5s ease";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500); // hapus elemen setelah fade out
            }
        }, 3000);
    </script>
</body>

</html>
