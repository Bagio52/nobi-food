<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function showCekPesanan(Request $request)
    {
        $id_produk = $request->query('id_produk');
        $nama_produk = $request->query('nama_produk');
        $harga = $request->query('harga');

        return view('order.cek-pesanan', compact('nama_produk', 'harga', 'id_produk'));
    }

    public function cekKuota(Request $request)
    {
        $request->validate([
            'tanggal_pengambilan' => 'required|date',
        ]); // Validasi tanggal pengambilan

        $tanggal_pengambilan = $request->input('tanggal_pengambilan');
        $jumlah_pesanan = \App\Models\Pesanan::whereDate('tanggal_pengambilan', $tanggal_pengambilan)->sum('jumlah_pesanan');

        // Ambil dari database
        $kuotaMaksimum = Pengaturan::where('nama', 'kuota_maksimum')->first()?->nilai ?? 20;

        if ($jumlah_pesanan >= $kuotaMaksimum) {
            return back()->with([
                'status' => 'penuh',
                'tanggal_pengambilan' => $tanggal_pengambilan,
            ]);
        } else {
            $sisaKuota = $kuotaMaksimum - $jumlah_pesanan;
            return back()->with([
                'status' => 'tersedia',
                'sisa_kuota' => $sisaKuota,
                'tanggal_pengambilan' => $tanggal_pengambilan,
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'id_produk' => $request->id_produk,
            ]);
        }
    }

    public function showBuatPesanan(Request $request)
    {
        $tanggal_pengambilan = $request->query('tanggal_pengambilan'); // Mengambil tanggal dari query string
        $sisaKuota = $request->query('sisa_kuota'); // Mengambil sisa kuota dari query string
        $nama_produk = $request->query('nama_produk');
        $harga = $request->query('harga');
        $id_produk = $request->query('id_produk');



        if (!$tanggal_pengambilan || !$nama_produk || !$harga ) {
            return redirect()->route('order.cek-pesanan')->with('error', 'Tanggal pengambilan tidak ditemukan.');
        }

        $jumlah_pesanan = \App\Models\Pesanan::whereDate('tanggal_pengambilan', $tanggal_pengambilan)->sum('jumlah_pesanan');

        return view('order.buat-pesanan', compact(
            'tanggal_pengambilan',
            'sisaKuota',
            'nama_produk',
            'id_produk',
            'harga',
        ));
    }

    public function SimpanPesanan(Request $request)
    {
        $request->validate([
            'id_produk'           => 'required',
            'nama_pelanggan'      => 'required|string|max:255',
            'alamat'              => 'required|string|max:255',
            'no_telp'             => 'required|string|max:20',
            'tanggal_pengambilan' => 'required|date',
            'jumlah_pesanan'      => 'required|integer|min:1',
            'bukti_pembayaran'    => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Simpan pelanggan
            $pelanggan = Pelanggan::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat'         => $request->alamat,
                'no_telp'        => $request->no_telp,
            ]);

            // Validasi tanggal pengambilan
            $tanggal_pengambilan = Carbon::parse($request->tanggal_pengambilan);
            $sisaPesanan = $request->jumlah_pesanan;
            $produks = Produk::findOrFail($request->id_produk);


            $buktiPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }

            $pesanan_ids = [];

            while ($sisaPesanan > 0) {
                $jumlahSudahDipesan = Pesanan::whereDate('tanggal_pengambilan', $tanggal_pengambilan)->sum('jumlah_pesanan');
                $kuotaTersedia = max(0, 20 - $jumlahSudahDipesan);

                if ($kuotaTersedia <= 0) {
                    $tanggal_pengambilan->addDay(); // pindah ke hari berikutnya
                    continue;
                }

                $jumlahUntukHariIni = min($sisaPesanan, $kuotaTersedia);

                // Hitung nomor antrian
                $nomor_antrian = Pesanan::whereDate('tanggal_pengambilan', $tanggal_pengambilan)->count() + 1;

                // Simpan pesanan
                $pesanan = Pesanan::create([
                    'id_produk'           => $produks->id,
                    'id_pelanggan'        => $pelanggan->id,
                    'tanggal_pengambilan' => $tanggal_pengambilan->toDateString(),
                    'tanggal_pesan'       => Carbon::now(),
                    'jumlah_pesanan'      => $jumlahUntukHariIni,
                    'nomor_antrian'       => $nomor_antrian,
                    'bukti_pembayaran'    => $buktiPath,
                ]);

                $total_harga = $jumlahUntukHariIni * $produks->harga;

                DetailPesanan::create([
                    'id_pelanggan' => $pelanggan->id,
                    'id_produk'    => $produks->id,
                    'id_pesanan'   => $pesanan->id,
                    'total_harga'  => $total_harga,
                ]);

                $pesanan_ids[] = $pesanan->id;

                $sisaPesanan -= $jumlahUntukHariIni;
                $tanggal_pengambilan->addDay(); // pindah tanggal untuk berikutnya
            }

            DB::commit();

            return redirect()->route('order.rincian-pesanan', ['id' => $pesanan_ids[0]]) // redirect ke pesanan pertama
                ->with('success', 'Pesanan berhasil dibuat, mungkin terbagi dalam beberapa hari.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan pesanan. ' . $e->getMessage());
        }
    }
    public function rincianPesanan($id)
    {
        $pesananPertama = Pesanan::with('produk', 'pelanggan')->findOrFail($id);
        $id_pelanggan = $pesananPertama->id_pelanggan;

        // Ambil semua pesanan milik pelanggan tersebut
        $semuaPesanan = Pesanan::with('produk')
            ->where('id_pelanggan', $id_pelanggan)
            ->orderBy('tanggal_pengambilan')
            ->get();

        // Ambil semua detail pesanan
        $detailPesanan = DetailPesanan::where('id_pelanggan', $id_pelanggan)->get();

        return view('order.rincian-pesanan', [
            'pelanggan' => $pesananPertama->pelanggan,
            'semuaPesanan' => $semuaPesanan,
            'detailPesanan' => $detailPesanan,
        ]);
    }
}
