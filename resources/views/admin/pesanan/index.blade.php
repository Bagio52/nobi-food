@extends('layouts.admin')

@section('content')
    <h2 class="text-center mb-4">Daftar Pesanan Pelanggan</h2>


    <div class="d-flex justify-content-between mb-3">
        <form id="filter-form" class="form-inline">
            <label for="filter-date" class="mr-2">Tanggal:</label>
            <input type="date" id="filter-date" class="form-control mr-2">
            <button type="submit" class="btn btn-secondary">Filter</button>
        </form>

        <form id="search-name-form" class="form-inline">
            <label for="search-name" class="mr-2">Cari nama:</label>
            <input type="text" id="sort-name" class="form-control mr-2" placeholder="Masukkan nama">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="form-inline">
            @csrf
            <div class="form-group mr-2">
                <label for="kuota_maksimum" class="mr-2">Ubah Kuota Maksimum:</label>
                <input type="number" name="kuota_maksimum" id="kuota_maksimum"
                    class="form-control @error('kuota_maksimum') is-invalid @enderror" value="{{ $kuota->nilai ?? '' }}"
                    min="1" required>
                @error('kuota_maksimum')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover text-center" id="pesanan-table"
            style="font-size: 10px;">
            <thead class="border-bottom font-weight-bold" style="background-color: #079421; color: white;">
                <tr>
                    <th>Tanggal Pesan</th>
                    <th>Tanggal Pengambilan</th>
                    <th>Nomor Antrian</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No Telp</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total Harga</th>
                    <th>Bukti Pembayaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanans as $pesanan)
                    <tr data-tanggal_pengambilan="{{ $pesanan->tanggal_pengambilan }}">
                        <td>{{ $pesanan->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pengambilan)->format('d/m/Y') }}</td>
                        <td>{{ $pesanan->nomor_antrian }}</td>
                        <td>{{ $pesanan->pelanggan->nama_pelanggan }}</td>
                        <td>{{ $pesanan->pelanggan->alamat }}</td>
                        <td>{{ $pesanan->pelanggan->no_telp }}</td>
                        <td>{{ $pesanan->produk->nama_produk ?? '-' }}</td>
                        <td>{{ $pesanan->jumlah_pesanan }}</td>
                        <td>Rp {{ number_format($pesanan->produk->harga ?? 0, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format(($pesanan->produk->harga ?? 0) * $pesanan->jumlah_pesanan, 0, ',', '.') }}
                        </td>
                        <td>
                            @if ($pesanan->bukti_pembayaran)
                                <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" width="60"
                                    alt="Bukti Pembayaran" style="cursor: pointer;"
                                    onclick="showImageModal('{{ asset('storage/' . $pesanan->bukti_pembayaran) }}')">
                            @else
                                Tidak ada
                            @endif
                        </td>
                        <td>Sudah Dilayani</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Gambar --}}
    <div id="imageModal"
        style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color: rgba(0,0,0,0.8);">
        <span onclick="closeImageModal()"
            style="position:absolute; top:20px; right:35px; color:white; font-size:40px; cursor:pointer;">&times;</span>
        <img id="modalImage" style="display:block; margin:auto; max-width:90%; max-height:90%;">
    </div>

    {{-- Script Filter, Sort, Modal --}}
    <script>
        document.getElementById('filter-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const filterDate = document.getElementById('filter-date').value;
            const rows = document.querySelectorAll('#pesanan-table tbody tr');
            rows.forEach(row => {
                const pengambilanDate = new Date(row.getAttribute('data-tanggal_pengambilan'));
                const filterDateObj = new Date(filterDate);
                if (filterDate) {
                    row.style.display = (pengambilanDate.toDateString() === filterDateObj.toDateString()) ? '' :
                        'none';
                } else {
                    row.style.display = '';
                }
            });
        });


        document.getElementById('search-name-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const searchName = document.getElementById('sort-name').value.toLowerCase();
            const rows = document.querySelectorAll('#pesanan-table tbody tr');
            rows.forEach(row => {
                const nameCell = row.cells[3].textContent.toLowerCase();
                row.style.display = nameCell.includes(searchName) ? '' : 'none';
            });
        });

        function showImageModal(src) {
            document.getElementById("modalImage").src = src;
            document.getElementById("imageModal").style.display = "block";
        }

        function closeImageModal() {
            document.getElementById("imageModal").style.display = "none";
        }

        window.onclick = function(event) {
            const modal = document.getElementById("imageModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
@endsection
