<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Models\Admin;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::get('/cek-pesanan', [PesananController::class, 'showCekPesanan'])->name('order.cek-pesanan');
Route::post('/cek-pesanan', [PesananController::class, 'cekKuota'])->name('order.cek-kuota');
Route::get('/buat-pesanan', [PesananController::class, 'showBuatPesanan'])->name('order.buat-pesanan');
Route::post('/simpan-pesanan', [PesananController::class, 'SimpanPesanan'])->name('order.simpan-pesanan');
Route::get('/rincian-pesanan/{id}', [PesananController::class, 'rincianPesanan'])->name('order.rincian-pesanan');

//Admin
Route::get('/login-admin', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login-admin', [AdminLoginController::class, 'login']);
Route::post('/logout-admin', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Route::get('/admin/dashboard', function () {
//     return view ('admin.dashboard');
// })->middleware('auth:admin');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware('auth:admin');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/dashboard/chart-data', [AdminController::class, 'chartData']);
Route::get('/dashboard/chart-data-harian', [AdminController::class, 'ChartDataHarian']);
Route::get('/dashboard/produk-favorit', [AdminController::class, 'produkFavorit']);


Route::get('/admin/pesanan',[AdminController::class, 'index'])->name('admin.pesanan');
Route::get('/admin/pesanan/{id}', [AdminController::class, 'detailpesanan'])->name('admin.pesanan.detail');
Route::post('/admin/pengaturan', [AdminController::class, 'updatePengaturan'])->name('admin.pengaturan.update');


Route::get('/admin/produk', [AdminController::class, 'produk'])->name('admin.produk');
Route::get('/admin/produk/create', [AdminController::class, 'create'])->name('admin.produk.create');
Route::post('/admin/produk', [AdminController::class, 'store'])->name('admin.produk.store');
Route::get('/produk/{id}/edit', [AdminController::class, 'edit'])->name('admin.produk.edit');
Route::put('/produk/{id}', [AdminController::class, 'update'])->name('admin.produk.update');
Route::delete('/produk/{id}', [AdminController::class, 'destroy'])->name('admin.produk.destroy');


