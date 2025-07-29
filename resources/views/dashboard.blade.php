@extends('components.navbar')

@section('content')
    <!-- Informasi nobi.food -->
    <div class="container mt-4" style="text-align: center;">
        <h1 class="display-4">Selamat Datang di nobi.food</h1>
        <p class="lead">Makanan Sehat dan Halal untuk Anda</p>
        <p class="lead">Hommade - Sertifikasi Halal By MUI - Magelang - Good food Good Mood</p>
        <hr class="my-4">
        <p>Pesan sekarang dan nikmati hidangan lezat kami!</p>
    </div>

    <!-- Daftar Produk -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Daftar Produk</h2>
        <div class="row justify-content-center">
            @foreach ($produks as $produk)
                <div class="col-md-3 mb-3">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top"
                            alt="{{ $produk->nama_produk }}" style="height: 250px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                            <p class="card-text text-muted mb-3">Harga: <strong>Rp
                                    {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                            <p class="card-text text-muted mb-3">
                                Total dipesan: <strong>{{ $produk->total_dipesan }}</strong> pcs
                            </p>

                            <a href="{{ route('order.cek-pesanan', [
                                'id_produk' => $produk->id,
                                'nama_produk' => $produk->nama_produk,
                                'harga' => $produk->harga,
                            ]) }}"
                                class="btn btn-success mt-auto">Buat Pesanan</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
