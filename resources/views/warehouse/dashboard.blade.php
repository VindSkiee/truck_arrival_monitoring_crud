<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Dashboard</title>
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

        .form-container {
            background-color: #f9fafb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
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
                <h1 class="text-xl font-bold">WAREHOUSE SONOCO</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('warehouse.monitor') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                    Monitor Warehouse
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

    <div class="p-4 max-w-full mx-auto">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($checks->isEmpty())
            <div class="flex flex-col items-center justify-center py-10 mt-52">
                <i class="fas fa-truck text-4xl text-gray-400 mb-2"></i>
                <p class="text-gray-600 text-center">Belum ada truck yang ditambahkan <b>hari ini.</b></p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($checks as $check)
                    <div class="truck-card bg-white border rounded-lg shadow-sm overflow-hidden">
                        <div
                            class="bg-gradient-to-r from-blue-50 to-gray-50 px-4 py-3 flex justify-between items-center border-b flex-wrap">
                            <div class="flex items-center">
                                <h2 class="font-semibold text-gray-800">
                                    <i class="fas fa-truck mr-2"></i>Truck - {{ $check->no_truck ?? '-' }}
                                </h2>
                            </div>
                            <div class="flex items-center space-x-2 mt-2 md:mt-0">
                                <span class="text-xs text-gray-600 font-bold">{{ $check->arrival_number }}</span>
                            </div>
                        </div>

                        <div class="p-4">
                            <!-- Informasi Truck -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div class="info-card bg-gray-50 p-3 rounded border">
                                    <div class="info-row">
                                        <span class="text-xs text-gray-500 font-bold">Loading Dock</span>
                                        <span
                                            class="text-sm font-medium">{{ $check->loading_dock ?? 'Not assigned' }}</span>
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
                                        <span class="text-xs text-gray-500 font-bold">Jumlah Box</span>
                                        <span class="text-sm font-medium">{{ $check->total_qty_box ?? 0 }}</span>
                                    </div>

                                    <div class="info-row">
                                        <span class="text-xs text-gray-500 font-bold">Berat</span>
                                        <span class="text-sm font-medium">{{ $check->total_load_weight ?? 0 }}</span>
                                    </div>
                                </div>

                                <div class="info-card bg-gray-50 p-3 rounded border">
                                    <!-- <div class="info-row">
                                    <span class="text-xs text-gray-500 font-bold">Current Dock</span>
                                    <span class="text-sm font-medium">{{ $check->loading_dock ?? 'Not assigned' }}</span>
                                </div> -->
                                    <div class="info-row">
                                        <span class="text-xs text-gray-500 font-bold">status loading</span>
                                        <span
                                            class="status-badge {{ $check->status_process == 'finish' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $check->status_process ?? '-' }}
                                        </span>
                                    </div>
                                    <div class="info-row">
                                        <span class="text-xs text-gray-500 font-bold">Remarks</span>
                                        <span class="text-sm font-medium">{{ $check->remarks ?? '-' }}</span>
                                    </div>
                                </div>

                                <div class="info-card bg-gray-50 p-3 rounded border">
                                    <h3 class="text-sm font-bold text-gray-700 mb-2">Update Loading Status</h3>
                                    <form action="{{ route('warehouse.updateLoadingStatus', $check->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-2">
                                            <label class="block text-xs text-gray-600 mb-1">Loading Dock</label>
                                            <input type="text" name="loading_dock"
                                                value="{{ $check->loading_dock ?? '' }}"
                                                class="border rounded p-2 text-sm w-full"
                                                placeholder="Enter dock number" required pattern="[A-Za-z0-9-]+"
                                                title="Only letters, numbers and hyphens are allowed">
                                        </div>

                                        <div class="mb-2">
                                            <label class="block text-xs text-gray-600 mb-1">Status</label>
                                            <select name="loading_status" class="border rounded p-2 text-sm w-full"
                                                required>
                                                <option value="">Select status</option>
                                                <option value="loading"
                                                    {{ $check->status_process == 'loading' ? 'selected' : '' }}>Loading
                                                </option>
                                                <option value="finish"
                                                    {{ $check->status_process == 'finish' ? 'selected' : '' }}>Finish
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="block text-xs text-gray-600 mb-1">Remarks (optional)</label>
                                            <input type="text" name="remarks" value="{{ $check->remarks ?? '' }}"
                                                class="border rounded p-2 text-sm w-full" placeholder="Add remarks">
                                        </div>

                                        <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm w-full">
                                            Update Status
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Box Placement Section -->

                        </div>
                    </div>
                @endforeach
            </div>
        @endif


    </div>

    <script>
        // Function to handle adding boxes (client-side for demo)


        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    // Basic validation for required fields
                    const requiredFields = form.querySelectorAll('[required]');
                    let valid = true;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            valid = false;
                            field.classList.add('border-red-500');
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    });

                    if (!valid) {
                        e.preventDefault();
                        alert('Please fill all required fields');
                    }
                });
            });
        });
    </script>
</body>

</html>
