<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Papertech - {{ ucfirst($role) }} Login</title>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #27ae60;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgb(172, 172, 172);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--dark);
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }

        .logo {
            width: 120px;
            margin-bottom: 80px;
        }

        h2 {
            color: var(--primary);
            margin-bottom: 50px;
            font-weight: 600;
        }

        .role-badge {
            display: inline-block;
            padding: 5px 15px;
            background: var(--secondary);
            color: white;
            border-radius: 20px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border 0.3s;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: var(--dark);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--dark);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: rgb(83, 83, 83);
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <img src="{{ asset('pics/Sonoco.png') }}" alt="Company Logo" class="logo">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            <div class="form-group">
                <label for="username">Masukkan Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required
                    placeholder="{{ $role }}">
            </div>

            <div class="form-group">
                <label for="password">Masukkan Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••"
                    autocomplete="off">
            </div>

            <button type="submit">Masuk</button>
        </form>

        <div class="footer">
            PT. Papertech &copy; {{ date('Y') }}. All rights reserved.
</body>

</html>
