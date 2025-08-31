<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 9999px;
        }
        .navbar {
            background-color: #1E3A8A;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body class="bg-gray-50">

<!-- Navbar -->
<nav class="navbar text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center">
            <div class="logo-container mr-3 bg-white rounded p-1 flex items-center justify-center">
                <img src="{{ asset('pics/Sonoco.png') }}" alt="Sonoco Logo" class="h-8">
            </div>
            <h1 class="text-xl font-bold">SECURITY SONOCO</h1>
        </div>
        <div class="flex items-center space-x-4">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="hover:text-gray-300">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="p-4 max-w-full mx-auto">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="space-y-4">
        @foreach($checks as $check)
        <div class="truck-card bg-white border rounded-lg shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-gray-50 px-4 py-3 flex justify-between items-center border-b flex-wrap">
                <div class="flex items-center">
                    <h2 class="font-semibold text-gray-800">
                        <i class="fas fa-truck mr-2"></i>Truck - {{ $check->no_truck ?? '-' }}
                    </h2>
                </div>
                <div class="flex items-center space-x-2 mt-2 md:mt-0">
                    <span class="text-xs text-gray-600 font-bold">{{ $check->arrival_number }}</span>
                </div>
            </div>

            <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Info Truck -->
                <div class="bg-gray-50 p-3 rounded border">
                    <div class="info-row">
                        <span class="text-xs text-gray-500 font-bold">Tanggal</span>
                        <span class="text-sm font-medium">{{ $check->date ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="text-xs text-gray-500 font-bold">No Kedatangan</span>
                        <span class="text-sm font-medium">{{ $check->arrival_number ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="text-xs text-gray-500 font-bold">No Truck</span>
                        <span class="text-sm font-medium">{{ $check->no_truck ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="text-xs text-gray-500 font-bold">Timbang Kosong</span>
                        <span class="text-sm font-medium">{{ number_format($check->empty_weight ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="text-xs text-gray-500 font-bold">Berat Material</span>
                        <span class="text-sm font-medium">{{ number_format($check->total_load_weight ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="text-xs text-gray-500 font-bold">Berat Total</span>
                        <span class="text-sm font-medium">{{ number_format($check->sum_empty_load_weight ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Remarks -->
                <div class="bg-gray-50 p-3 rounded border">
                    <div class="info-row">
                        <span class="text-xs text-gray-500 font-bold">Timbang Isi</span>
                        <span class="text-sm font-medium">{{ number_format($check->cargo_weight ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="text-xs text-gray-500 font-bold">Toleransi</span>
                        <span class="text-sm font-medium">{{ number_format($check->tolerance_weight ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="text-xs text-gray-500 font-bold">Loading dock</span>
                        <span class="text-sm font-medium {{ $check->status_process=='finish'?'bg-green-100 text-green-800':'bg-yellow-100 text-yellow-800' }}">{{ $check->status_process ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="text-xs text-gray-500 font-bold">Status</span>
                        <span class="status-badge {{ $check->status_security=='pass'?'bg-green-100 text-green-800':'bg-red-100 text-red-800' }}">
                            {{ $check->status_security ?? '-' }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="text-xs text-gray-500 font-bold">Remarks</span>
                        <span class="text-sm font-medium">{{ $check->remarks ?? '-' }}</span>
                    </div>
                </div>

                <!-- Update Form -->
                <div class="bg-gray-50 p-3 rounded border">
                    <h3 class="text-sm font-bold text-gray-700 mb-2">Update Truck Data</h3>
                    <form action="{{ route('security.updateTruckData', $check->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            <label class="block text-xs text-gray-600 mb-1">No Truck</label>
                            <input type="text" name="no_truck" value="{{ $check->no_truck ?? '' }}" class="border rounded p-2 text-sm w-full" required>
                        </div>
                        <div class="mb-2">
                            <label class="block text-xs text-gray-600 mb-1">Timbang Kosong</label>
                            <input type="number" step="0.01" name="empty_weight" value="{{ $check->empty_weight ?? 0 }}" class="border rounded p-2 text-sm w-full" required>
                        </div>
                        <div class="mb-2">
                            <label class="block text-xs text-gray-600 mb-1">Timbang Isi</label>
                            <input type="number" step="0.01" name="cargo_weight" value="{{ $check->cargo_weight ?? 0 }}" class="border rounded p-2 text-sm w-full" required>
                        </div>
                        <div class="mb-2">
                            <label class="block text-xs text-gray-600 mb-1">Remarks</label>
                            <input type="text" name="remarks" value="{{ $check->remarks ?? '' }}" class="border rounded p-2 text-sm w-full">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm w-full">Update</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

</body> 
</html>
