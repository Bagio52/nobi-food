@extends('layouts.admin')

@section('content')
    <h2 class="text-center">Daftar Produk</h2>

    <div class="mb-3 text-left">
        <a href="{{ route('admin.produk.create') }}" class="btn btn-warning">
            Tambah Produk
        </a>
    </div>

    <div style="table-responsive">
        <table class="table table-bordered text-center" style="margin-top: 20px;">
            <thead class="border-bottom font-weight-bold" style="background-color: #079421; color: white;">
                <tr>
                    {{-- <th>No</th> --}}
                    <th>Nama PRODUK</th>
                    <th>Gambar</th>
                    <th>Harga</th>
                    <th>Waktu Pembuatan</th>
                    <th>Aksi</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($produks as $produk)
                    <tr>
                        {{-- <td>{{$produk->id}}</td> --}}
                        <td>{{ $produk->nama_produk }}</td>
                        <td>
                            <img src="{{ asset('storage/' .$produk->gambar) }}" alt="{{ $produk->nama_produk }}" width="60">
                        </td>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>{{ $produk->waktu_pembuatan }}</td>
                        <td>
                            <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
