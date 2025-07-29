@extends('layouts.admin')
@section('content')
    <h1 style="text-align: center;">Edit Produk</h1>

    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data"
        style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk" value="{{ $produk->nama_produk }}" required
                style="width: 100%; padding: 10px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="gambar">Gambar</label>
            {{-- @if ($produk->gambar)
            <img src="{{ asset('storage/' . $produk->gambar) }}" width="100" class="mb-2">
        @endif --}}
            <input type="file" id="gambar" name="gambar" style="width: 100%; padding: 10px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="harga">Harga</label>
            <input type="text" id="harga" name="harga" value="{{ $produk->harga }}" required
                style="width: 100%; padding: 10px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="waktu_pembuatan">Waktu Pembuatan</label>
            <input type="text" id="waktu_pembuatan" name="waktu_pembuatan" value="{{ $produk->waktu_pembuatan }}"
                required style="width: 100%; padding: 10px;">
        </div>


        <div>
            <button type="submit"
                style="background-color: #007bff; color: white; padding: 10px;  border: none; border-radius: 5px;">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.produk') }}" class="btn btn-danger">Batal</a>
        </div>

        <div></div>
    </form>
@endsection
