<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <title>Nobi.food id</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding-top: 100px;
        }

        .navbar {
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
            padding: 0.3rem 1rem;
        }

        .navbar-brand img {
            width: 60px;
            height: 60px;
            margin-right: 10px;
        }

        .navbar-brand span {
            font-size: 1.5rem;
            font-weight: bold;
            color: #079421
        }
        .content {
            font: 1em sans-serif;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 1200px;
        }
        .content h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #079421;
        }
        .content h2 {
            font-size: 2.0rem;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            color: #079421;
        }

        .content p {
            font-size: 1.2rem;
            color: #333;
            text-align: center;
            margin-bottom: 5px;
            line-height: 1.6;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
            position: relative;
            bottom: 100%;
            width: 100%;
        }

        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            height: 450px;
            object-fit: cover;
        }
        .card-title {
            font-size: 1.5rem;
            /* font-weight: bold; */
            text-align: center;
        }
        .card-text {
            font-size: 1.2rem;
            text-align: center;
        }

        .produk {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <div class="row w-100 align-items-center">
                <!-- Logo kiri -->
                <div class="col-4 d-flex align-items-center">
                    <a class="navbar-brand d-flex align-items-center">
                        <img src="{{ asset('assets\logo-nobi.png') }}" alt="Logo">
                        <span class="ml-2">nobi.food id</span>
                    </a>
                </div>

                {{-- <!-- Teks tengah -->
                <div class="col-4 text-center">
                    <h1 class="h5 mb-0">Selamat Datang !!!</h1>
                </div> --}}

                <!-- Tombol kanan -->
                <div class="col-8 d-flex justify-content-end">
                    <a href="{{ route('admin.login') }}" class="btn btn-sm" style="background-color: #079421; color: white;">
                        Login Admin?
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="content">
        @yield('content')
    </div>
    <footer class="text-center mt-5">
        <p>&copy; 2025 nobi.food-bySbg. All rights reserved.</p>
        <p>Hommade - Sertifikasi Halal by MUI - Magelang - Good food Good Mood</p>
    </footer>
</body>

</html>
