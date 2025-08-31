<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Papertech - Select Login Area</title>
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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: var(--dark);
        }

        .logo-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.2;
            max-width: 40%;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        h1 {
            color: var(--dark);
            margin-bottom: 30px;
            font-weight: 600;
        }

        .role-card {
            display: block;
            background: var(--light);
            border: 1px solid #e0e0e0;
            border-radius: 25px;
            padding: 25px;
            margin-bottom: 15px;
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            width: 220px;
            margin-left: auto;
            margin-right: auto;
        }

        .role-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }



        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <!-- Logo sebagai background dengan opacity -->
    <img src="{{ asset('pics/Sonoco.png') }}" alt="Company Logo" class="logo-bg">

    <!-- Konten utama -->
    <div class="content">
        <h1>Pilih Area Login</h1>

        <a href="{{ route('login.role', 'cs') }}" class="role-card cs">CS</a>
        <a href="{{ route('login.role', 'security') }}" class="role-card security">Security</a>
        <a href="{{ route('login.role', 'warehouse') }}" class="role-card security">Warehouse</a>
        <a href="{{ route('login.role', 'admin') }}" class="role-card security">Admin</a>

        <div class="footer">
            PT. Papertech Indonesia &copy; 2025 - All Rights Reserved
            <br>
            Developed by Arvind - Hafizh - Tel-U
        </div>
    </div>
</body>

</html>
