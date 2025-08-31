<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Warehouse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <style>
        .status-badge {
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 9999px;
        }
        .navbar { background-color: #1E3A8A; }
    </style>
</head>
<body class="bg-gray-50">

<nav class="navbar text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold">MONITOR WAREHOUSE</h1>
    </div>
</nav>

<div class="p-4 max-w-full mx-auto">
    <table class="min-w-full divide-y divide-gray-200 bg-white shadow rounded-lg">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="px-4 py-2 text-left">Loading Dock</th>
                <th class="px-4 py-2 text-left">Arrival Number</th>
                <th class="px-4 py-2 text-left">No Truck</th>
                <th class="px-4 py-2 text-left">Status Process</th>
            </tr>
        </thead>
        <tbody id="truck-table" class="divide-y divide-gray-200">
            <!-- Data akan di-load via AJAX -->
        </tbody>
    </table>
</div>

<script>
function fetchData() {
    $.get("{{ route('monitor.warehouse.data') }}", function(data) {
        let rows = '';
        data.forEach(truck => {
            let statusClass = truck.status_process === 'finish' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
            rows += `<tr>
                <td class="px-4 py-2">${truck.loading_dock ?? '-'}</td>
                <td class="px-4 py-2">${truck.arrival_number ?? '-'}</td>
                <td class="px-4 py-2">${truck.no_truck ?? '-'}</td>
                <td class="px-4 py-2">
                    <span class="status-badge ${statusClass}">${truck.status_process ?? '-'}</span>
                </td>
            </tr>`;
        });
        $('#truck-table').html(rows);
    });
}

// Load pertama
fetchData();

// Refresh tiap 5 detik
setInterval(fetchData, 5000);
</script>

</body>
</html>

