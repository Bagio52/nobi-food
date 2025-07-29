<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class AdminController extends Controller
{
    // Menampilkan dashboard admin
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Mengambil data chart untuk dashboard
    public function chartData(Request $request)
    {
        $bulan = $request->query('bulan', now()->month); // Mengambil bulan dari query string, default ke bulan saat ini

        // Mengambil data jumlah pesanan per produk
        $data = DB::table('produks')
            ->leftJoin('pesanans', function ($join) use ($bulan) {
                $join->on('produks.id', '=', 'pesanans.id_produk')
                    ->whereMonth('pesanans.tanggal_pengambilan', $bulan);
            })
            ->select('produks.nama_produk', DB::raw('COALESCE(SUM(pesanans.jumlah_pesanan), 0) as jumlah_pesanan'))
            ->groupBy('produks.nama_produk')
            ->orderBy('produks.nama_produk')
            ->get();

        return response()->json($data);
    }

    //Mengabil data chart harian
    public function ChartDataHarian(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = now()->year;

        // Ambil jumlah pesanan per tanggal dalam bulan yang dipilih
        $data = DB::table('pesanans')
            ->select('tanggal_pengambilan', DB::raw('SUM(jumlah_pesanan) as jumlah_pesanan'))
            ->whereMonth('tanggal_pengambilan', $bulan)
            ->whereYear('tanggal_pengambilan', $tahun)
            ->groupBy('tanggal_pengambilan')
             ->orderBy('tanggal_pengambilan')
            ->get();
            // ->select(DB::raw('DATE(created_at) as tanggal_pengambilan'), DB::raw('SUM(jumlah_pesanan) as jumlah_pesanan'))
            // ->groupBy(DB::raw('DATE(tanggal_pengambilan)'))
            // ->whereMonth('created_at', $bulan)
            // ->whereYear('created_at', $tahun)
            // ->groupBy(DB::raw('DATE(created_at)'))


        return response()->json($data);
    }

    // Mengambil data produk favorit
    public function produkFavorit(Request $request)
    {
        $query = DB::table('pesanans')
            ->join('produks', 'pesanans.id_produk', '=', 'produks.id')
            ->select('produks.nama_produk', DB::raw('SUM(pesanans.jumlah_pesanan) as jumlah_pesanan'))
            ->groupBy('produks.nama_produk')
            ->orderByDesc('jumlah_pesanan');

        if ($request->filled('bulan')) {
            $query->whereMonth('pesanans.tanggal_pengambilan', $request->bulan);
        }

        return response()->json($query->first());
    }

    // Menampilkan daftar pesanan
    public function index()
    {
        $pesanans = Pesanan::with(['pelanggan', 'produk'])->latest()->get();
        $kuota = Pengaturan::where('nama', 'kuota_maksimum')->first();

        return view('admin.pesanan.index', compact('pesanans', 'kuota'));
    }

    public function editPengaturan()
    {
        $kuota = \App\Models\Pengaturan::where('nama', 'kuota')->first();
        return view('admin.pengaturan', compact('kuota'));
    }

    public function updatePengaturan(Request $request)
    {
        $request->validate([
            'kuota_maksimum' => 'required|integer|min:1',
        ]);

        Pengaturan::updateOrCreate(
            ['nama' => 'kuota_maksimum'],
            ['nilai' => $request->kuota_maksimum]
        );

        return back()->with('success', 'Pengaturan kuota maksimum berhasil diperbarui.');
    }

    // public function pesanan()
    // {
    //     $pesanans = Pesanan::orderBy('created_at', 'asc')->get();
    //     return view('admin.pesanan.index', compact('pesanans'));
    // }

    // Menampilkan daftar produk
    public function produk()
    {
        // Ambil data produk dari model (misalnya, Produk)
        $produks = Produk::all();

        // Kembalikan tampilan dengan data produk
        return view('admin.produk.index', compact('produks'));
    }

    // Menambahkan produk baru
    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan produk
        $request->validate([

            'nama_produk' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga' => 'required|numeric',
            'waktu_pembuatan' => 'required|string|max:255'
        ]);

        $path = $request->file('gambar')->store('images', 'public');

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'gambar' => $path,
            'harga' => $request->harga,
            'waktu_pembuatan' => $request->waktu_pembuatan,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    //edit
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'waktu_pembuatan' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $produk = Produk::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if (file_exists(public_path('storage/' . $produk->gambar))) {
                unlink(public_path('storage/' . $produk->gambar));
            }

            $path = $request->file('gambar')->store('images', 'public');
            $produk->gambar = $path;
        }

        $produk->nama_produk = $request->nama_produk;
        $produk->harga = $request->harga;
        $produk->waktu_pembuatan = $request->waktu_pembuatan;
        $produk->save();

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil diperbarui.');
    }

    //hapus
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus file gambar jika perlu
        if (file_exists(public_path($produk->gambar))) {
            unlink(public_path($produk->gambar));
        }

        $produk->delete();
        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus.');
    }


    public function detailpesanan($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'produk'])->findOrFail($id);

        return view('admin.detailpesanan', compact('pesanan'));
    }
}
