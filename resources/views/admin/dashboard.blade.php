<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">

    <!-- Navbar atas -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen User</h1>

        <!-- Tombol Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Logout
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-200 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form tambah user -->
    <form action="{{ route('admin.users.store') }}" method="POST" class="mb-6 p-4 bg-white rounded shadow">
        @csrf
        <div class="grid grid-cols-3 gap-4">
            <input type="text" name="username" placeholder="Username"
                   class="border p-2 rounded" required>

            <input type="password" name="password" placeholder="Password"
                   class="border p-2 rounded" required>

            <select name="role" class="border p-2 rounded" required>
                <option value="">-- Pilih Role --</option>
                <option value="cs">CS</option>
                <option value="security">Security</option>
                <option value="warehouse">Warehouse</option>
            </select>
        </div>
        <button type="submit" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded">Tambah User</button>
    </form>

    <!-- Tabel daftar user -->
    <table class="w-full bg-white shadow rounded border">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Username</th>
                <th class="p-2 border">Role</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td class="p-2 border text-center">{{ $user->id }}</td>
                <td class="p-2 border">{{ $user->username }}</td>
                <td class="p-2 border">{{ ucfirst($user->role) }}</td>
                <td class="p-2 border text-center">
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-4 text-center">Tidak ada user</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
