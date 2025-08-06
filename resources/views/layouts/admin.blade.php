<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-width-min: 80px;
            --primary-color: #2c3e50;
            --primary-text: #ecf0f1;
            --accent-color: #3498db;
            --logo-size: 40px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-left: var(--sidebar-width);
            transition: padding-left 0.3s ease;
            background-color: #f4f7f6;
        }

        body.minimized-body {
            padding-left: var(--sidebar-width-min);
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--primary-color);
            color: var(--primary-text);
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: width 0.3s ease;
            overflow: hidden;
            z-index: 1000;
        }

        .sidebar.minimized {
            width: var(--sidebar-width-min);
        }

        .header-sidebar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 15px;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .sidebar.minimized .brand {
            opacity: 0;
            pointer-events: none;
        }

        .brand img {
            width: var(--logo-size);
            height: var(--logo-size);
            border-radius: 50%;
        }

        .brand-text {
            font-size: 1.1em;
            font-weight: bold;
            white-space: nowrap;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: var(--primary-text);
            font-size: 1.5em;
            cursor: pointer;
            transition: transform 0.3s ease;
            padding: 0;
            line-height: 1;
        }

        .sidebar.minimized .toggle-btn {
            transform: rotate(180deg);
        }

        .nav-links {
            flex-grow: 1;
            padding: 20px 0;
        }

        .nav-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-links li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: var(--primary-text);
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s ease, padding 0.3s ease;
            gap: 15px;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .nav-links li a:hover {
            background-color: var(--accent-color);
        }

        .nav-links li a i {
            font-size: 1.2em;
            width: 25px;
            text-align: center;
        }

        .nav-links li a span {
            opacity: 1;
            transition: opacity 0.3s ease;
            white-space: nowrap;
        }

        .sidebar.minimized .nav-links li a span {
            opacity: 0;
            width: 0;
            visibility: hidden;
        }

        .sidebar.minimized .nav-links li a {
            justify-content: center;
            padding: 15px;
        }

        .footer-sidebar {
            padding: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-btn {
            width: 100%;
            background-color: transparent;
            color: var(--primary-text);
            border: 1px solid #e74c3c;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            white-space: nowrap;
        }

        .logout-btn:hover {
            background-color: #e74c3c;
        }

        .sidebar.minimized .logout-btn span {
            display: none;
        }

        .sidebar.minimized .logout-btn {
            padding: 12px;
            width: auto;
        }

        .content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .content {
            padding: 50px;
            flex: 1;
            display: flex;
        }

        .content h2 {
            margin-bottom: 20px;
            color: #079421;
        }

        .footer-content {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 0.9em;
            text-align: center;
            color: #ecf0f1;
            padding: 10px;
            background-color: #2c3e50;
        }

        .btn-danger {
            display: inline-block;
        }
    </style>
</head>

<body>
    <!-- Wrapper dihapus karena menggunakan padding pada body -->
    <div class="sidebar" id="sidebar">
        <div class="header-sidebar">
            <div class="brand">
                <img src="{{ asset('assets/logo-nobi.png') }}" alt="logo">
                <span class="brand-text">nobi.food id</span>
            </div>
            <button class="toggle-btn" id="toggle-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="nav-links">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                <li><a href="{{ route('admin.pesanan') }}"><i class="fas fa-clipboard-list"></i> <span>Daftar Pesanan</span></a></li>
                <li><a href="{{ route('admin.produk') }}"><i class="fas fa-box-open"></i> <span>Daftar Produk</span></a>
                </li>
            </ul>
        </nav>

        <div class="footer-sidebar">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span></button>
            </form>
        </div>
    </div>

    <!-- Konten Halaman Anda Disini -->
    <div class="content-area">
        <div class="content" style="display: flex; flex-direction: column;">
            @yield('content')
        </div>

    </div>
    <div class="footer">
        <div class="footer-content">
            &copy; {{ date('Y') }} nobi.food_id - All rights reserved.
        </div>
    </div>

    <!-- JavaScript untuk Mengaktifkan Tombol Minimize -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggle-btn');
            const body = document.body;

            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('minimized');
                body.classList.toggle('minimized-body');
            });
        });
    </script>
</body>

</html>
