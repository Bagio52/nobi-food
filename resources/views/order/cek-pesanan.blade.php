@extends('components.navbar')

@section('content')
    <form action="{{ route('order.cek-kuota') }}" method="POST"
        style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9;">

        <h2 style="text-align: center">Cek Kuota Pesanan</h2>

        @csrf

        <input type="hidden" name="nama_produk" value="{{ $nama_produk }}">
        <input type="hidden" name="harga" value="{{ $harga }}">
        <input type="hidden" name="id_produk" value="{{ $id_produk }}">


        <label style="display: block; margin-bottom: 10px;">Pilih Tanggal untuk Pengambilan pesanan:</label>
        <input type="date" name="tanggal_pengambilan" required
            style="width: 100%; padding: 10px; border: 1px solid #ccc; margin-bottom: 20px; border-radius: 5px;">

        <div style="text-align: center;">
            <button type="submit"
                style="background-color: #28a745; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; ">Cek</button>
            {{-- <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a> --}}
        </div>

        <div>
            @if (session('status') == 'penuh')
                <p class="text-danger">Kuota penuh pada tanggal {{ session('tanggal_pengambilan') }} Silahkan ganti tanggal
                    pengambilan</p>
                {{-- <a href="{{ route('order.cek-pesanan') }}" class="btn btn-warning">Ganti Tanggal</a> --}}
                <a href="{{ route('dashboard') }}" class="btn btn-danger">Batal</a>
            @elseif (session('status') == 'tersedia')
                <p class="text-success">Tersisa {{ session('sisa_kuota') }} kuota pesanan dari kuota maksimum pada tanggal
                    {{ session('tanggal_pengambilan') }}
                </p>
                <a href="{{ route('order.buat-pesanan', [
                    'id_produk' => session('id_produk'),
                    'tanggal_pengambilan' => session('tanggal_pengambilan'),
                    'sisa_kuota' => session('sisa_kuota'),
                    'nama_produk' => session('nama_produk'),
                    'harga' => session('harga'),
                ]) }}"
                    class="btn btn-success" style="background-color: #28a755">Lanjut</a>
                <a href="{{ route('dashboard') }}" class="btn btn-danger">Batal</a>
            @endif
        </div>
    </form>
@endsection
