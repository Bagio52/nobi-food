@extends('components.navbar')

@section('content')
    <div class="container">


        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('order.simpan-pesanan') }}" method="POST" enctype="multipart/form-data"
            style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9;">

            @csrf
            <input type="hidden" name="id_produk" value="{{ $id_produk }}">

            <h2 class="text-center">Buat Pesanan</h2>


            <div class="mb-3">
                <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="no_telp" class="form-label">No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" required>
            </div>

            {{-- Tanggal Pengambilan (diambil dari cek kuota) --}}
            <div class="mb-3">
                <label>Tanggal Pengambilan</label>
                <input type="text" name="tanggal_pengambilan" value="{{ $tanggal_pengambilan }}" class="form-control"
                    readonly>
            </div>

            {{-- Nama Produk (diambil dari dashboard) --}}
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ $nama_produk }}" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label>Harga</label>
                <input type="text" id="harga" name="harga" value="Rp. {{ $harga }}" class="form-control"
                    readonly>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" id="jumlah" name="jumlah_pesanan" class="form-control" min="1" required>
                <div id="kuotaWarning" class="text-danger mt-1" style="display: none";></div>
            </div>

            <div class="mb-3">
                <label>Total Harga</label>
                <input type="text" id="total_harga" name="total_harga" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label>Silahkan melakukan pembayaran.</label><br>
                <label>Dp minimal 20% dari total harga melalui :</label>
                <label>Bank : BRI a.n Agisva Elvatikha Rahmatillah
                    308301049892530</b></label>

            </div>

            <div class="mb-3">
                <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Kirim Pesanan</button>
            <a href="{{ route('dashboard') }}" class="btn btn-danger">Batal Pesan</a>
        </form>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahInput = document.getElementById('jumlah');
            const hargaInput = document.getElementById('harga');
            const totalHargaInput = document.getElementById('total_harga');
            const sisaKuota = {{ $sisaKuota }}; // Mengambil sisa kuota dari server

            // console.log(sisa_kuota);


            // Kuota Warning
            const warning = document.createElement('div');
            warning.id = 'kuotaWarning';
            warning.className = 'text-danger mt-1';
            warning.style.display = 'none';
            jumlahInput.insertAdjacentElement('afterend', warning);

            function hitungTotal() {
                const jumlah = parseInt(jumlahInput.value) || 0;
                const harga = parseInt(hargaInput.value.replace(/\D/g, '')) || 0;
                const total_harga = jumlah * harga;

                // Format ke rupiah
                totalHargaInput.value = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(total_harga);

                // Cek kuota
                if (jumlah > sisaKuota) {
                    warning.style.display = 'block';
                    warning.innerText =
                        `Jumlah pesanan melebihi kuota yang tersedia (${sisaKuota   }).
                        Jika anda tetep ingin melanjutkan pesanan akan dijadwalkan di hari berikutnya.`;
                } else {
                    warning.style.display = 'none';
                }
            }

            jumlahInput.addEventListener('input', hitungTotal);
        });
    </script>
@endsection
