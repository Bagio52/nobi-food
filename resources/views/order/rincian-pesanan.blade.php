@extends('components.navbar')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <div class="container mt-5">
        <div id="rincian-pesanan" class="p-4 border rounded bg-light" style="max-width: auto; margin: auto;">
            <h2 class="text-center">Form Rincian Data Pesanan</h2>

            <div class="mb-4">
                <p><strong>Nama Pelanggan:</strong> {{ $pelanggan->nama_pelanggan }}</p>
                <p><strong>Alamat Pelanggan:</strong> {{ $pelanggan->alamat }}</p>
                <p><strong>Nomor Telepon:</strong> {{ $pelanggan->no_telp }}</p>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal Pesan</th>
                        <th>Tanggal Pengambilan</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>No Antrian</th>
                        <th>Bukti Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($semuaPesanan as $pesanan)
                        @php
                            $detail = $detailPesanan->firstWhere('id_pesanan', $pesanan->id);
                        @endphp
                        <tr>
                            <td>{{ $pesanan->created_at->format('d/m/Y H:i')}}</td>
                            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pengambilan)->format('d/m/Y') }}</td>
                            <td>{{ $pesanan->produk->nama_produk }}</td>
                            <td>{{ $pesanan->jumlah_pesanan }}</td>
                            <td>Rp {{ number_format($pesanan->produk->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->total_harga ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $pesanan->nomor_antrian }}</td>
                            <td>
                                @if ($pesanan->bukti_pembayaran)
                                    <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" width="100">
                                @else
                                    Tidak ada
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button id="download-btn" class="btn btn-primary mt-3">Unduh</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Selesai</a>
        </div>
    </div>

    <script>
        document.getElementById("download-btn").addEventListener("click", function () {
            const element = document.getElementById('rincian-pesanan');
            html2canvas(element, { scale: 2 }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'rincian-pesanan.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        });
    </script>
@endsection
