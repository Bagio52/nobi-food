@extends('components.navbar')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <div class="container mt-4">
        <div id="rincian-pesanan" class="p-4 border rounded bg-light" style="max-width: auto; margin: auto;">
            <h2 class="text-center" style="font-display: ">Form Rincian Data Pesanan</h2>

            <div class="mb-4">
                <p style="text-align: left"><strong>Nama Pelanggan :</strong> {{ $pelanggan->nama_pelanggan }}</p>
                <p style="text-align: left"><strong>Alamat Pelanggan :</strong> {{ $pelanggan->alamat }}</p>
                <p style="text-align: left"><strong>Nomor Telepon :</strong> {{ $pelanggan->no_telp }}</p>
                @foreach ($semuaPesanan as $pesanan)
                    @php
                        $detail = $detailPesanan->firstWhere('id_pesanan', $pesanan->id);
                    @endphp
                    <p style="text-align: left"><strong>Tanggal Pesan :</strong>
                        {{ $pesanan->created_at->format('d/m/Y H:i') }} </p>
                    <p style="text-align: left"><strong>Tanggal Pengambilan :</strong>
                        {{ \Carbon\Carbon::parse($pesanan->tanggal_pengambilan)->format('d/m/Y') }} </p>
                    <p style="text-align: left"><strong>Nomor Antrian :</strong> {{ $pesanan->nomor_antrian }} </p>
                    <p style="text-align: left"><strong>Produk:</strong> {{ $pesanan->produk->nama_produk }} </p>
                    <p style="text-align: left"><strong>Jumlah Pesanan : </strong> {{ $pesanan->jumlah_pesanan }} </p>
                    <p style="text-align: left"><strong>Harga Satuan : </strong> Rp
                        {{ number_format($pesanan->produk->harga, 0, ',', '.') }} </p>
                    <p style="text-align: left"><strong>Total Harga : </strong> Rp
                        {{ number_format($detail->total_harga ?? 0, 0, ',', '.') }}</p>
                    {{-- <p><strong>Bukti Pembayaran</strong>
                        @if ($pesanan->bukti_pembayaran)
                            <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" width="100">
                        @else
                            Tidak ada
                        @endif
                    </p> --}}
                @endforeach
            </div>
        </div>
        <button id="download-btn" class="btn btn-primary mt-3">Unduh</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Selesai</a>
    </div>

    <script>
        document.getElementById("download-btn").addEventListener("click", function() {
            const element = document.getElementById('rincian-pesanan');
            html2canvas(element, {
                scale: 2
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'rincian-pesanan.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        });
    </script>
@endsection
