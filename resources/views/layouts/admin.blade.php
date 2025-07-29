<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
            flex-direction: row;
        }

        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding: 20px;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background: #495057;
        }

        .logout {
            margin-top: auto;
        }

        .content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
            padding: 20px;
        }
        .content h2 {
            margin-bottom: 20px;
            color: #079421;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px;
        }

        /* button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        } */

        button:hover {
            background: #c82333;
        }

        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" >
            <div class="brand">
                <img src="{{ asset('assets/logo-nobi.png') }}" alt="logo" width="50" height="50">
                <span style="font-size: 18px; font-weight: bold;">nobi.food id</span>
            </div>

            <ul>
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.pesanan') }}">Daftar Pesanan</a></li>
                <li><a href="{{ route('admin.produk') }}">Daftar Produk</a></li>
            </ul>

            <form method="POST" action="{{ route('admin.logout') }}" class="logout">
                @csrf
                <button type="submit" class="btn btn-danger">Keluar</button>
            </form>
        </div>

        <div class="content-area">
            <div class="content" style="display: flex; flex-direction: column;">
                @yield('content')
            </div>
            <footer>
                &copy; {{ date('Y') }} nobi.food_id - All rights reserved.
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
