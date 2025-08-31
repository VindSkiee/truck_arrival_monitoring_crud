<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Custom CSS -->
    <style>
        /* Scrollbar halus */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background-color: rgba(59, 130, 246, 0.7); /* biru */
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(59, 130, 246, 0.9);
        }

        /* Hover animasi di navbar */
        nav a {
            transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
        }
        nav a:hover {
            color: #dbeafe;
            transform: translateY(-2px);
        }

        /* Card content */
        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
    <div class="min-h-screen flex flex-col">

        <!-- Navbar -->
        <header class="bg-blue-600 text-white p-4 shadow-md sticky top-0 z-50">
            <div class="w-full px-6 flex justify-between items-center">
                <h1 class="text-lg font-bold flex items-center gap-2">
                    🚛 <span>CS Dashboard</span>
                </h1>
                <nav class="space-x-6">
                    <a href="{{ route('cs.dashboard') }}" class="hover:underline">Home</a>
                    <a href="#" class="hover:underline">Reports</a>
                    <a href="#" class="hover:underline">Settings</a>
                </nav>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 w-full px-15 py-6 space-y-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-200 text-center py-3 text-sm">
            &copy; {{ date('Y') }} CS System. All rights reserved.
        </footer>

    </div>
</body>
</html>
