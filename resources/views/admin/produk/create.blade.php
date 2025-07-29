@extends('layouts.admin')

@section('content')
    <h1 style="text-align: center;">Tambah Produk</h1>

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9;">
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="nama_produk" style="display: block; margin-bottom: 5px;">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="gambar" style="display: block; margin-bottom: 5px;">Gambar</label>
            <input type="file" id="gambar" name="gambar" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="harga" style="display: block; margin-bottom: 5px;">Harga</label>
            <input type="text" id="harga" name="harga" required step="0.01" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="waktu_pembuatan" style="display: block; margin-bottom: 5px;">Waktu Pembuatan</label>
            <input type="text" id="waktu_pembuatan" name="waktu_pembuatan" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div>
            <button type="submit" style="background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; width: 100%;">
                Simpan Produk
            </button>
        </div>
    </form>
@endsection
