<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        input {
            width: 100%;
            padding: 0.5rem;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 0.5rem;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .logo {
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="logo">
            <h2>Form Login Admin</h2>
            <img src="{{ asset('assets\logo-nobi.png') }}" alt="logo"
            style="width: 100px; display: block; margin: 0 auto;">
        </div>


        <form method="POST" action="{{ url('/login-admin') }}">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan Password" required>
            </div>
            <button type="submit">Masuk</button>
        </form>
        @if ($errors->any())
            <div style="color: red; margin-top: 10px;">{{ $errors->first() }}</div>
        @endif
    </div>
</body>

</html>
