@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>Dashboard Admin</h2>
        <p>Selamat datang di dashboard admin!</p>

        {{-- Filter Bulan --}}
        <div class="mb-3">
            <label for="bulanFilter" class="form-label">Filter Bulan:</label>
            <select id="bulanFilter" class="form-select" style="width: 250px">
                <option value="">Bulan ini</option>
                @foreach (range(1, 12) as $bulan)
                    <option value="{{ $bulan }}">{{ date('F', mktime(0, 0, 0, $bulan, 1)) }}</option>
                @endforeach
            </select>
        </div>

        {{-- Produk Favorit --}}
        <div class="alert alert-success" id="produkFavoritBox">
            <strong>🏆 Produk Favorit:</strong> <span id="produkFavoritText">Memuat...</span>
        </div>

        {{-- Grafik Pesanan per Produk --}}
        <canvas id="pesananChart" width="1000" height="300" class="mt-4"></canvas>

        <hr class="my-2">

        <canvas id="chartHarian" width="1000" height="300" class="mt-2"></canvas>

        <hr class="my-2">
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const bulanSelect = document.getElementById('bulanFilter');
            const ctxProduk = document.getElementById('pesananChart').getContext('2d');

            let chartProduk;


            // Chart jumlah pesanan per produk
            function fetchChartData(bulan = '') {
                const url = bulan ? `/dashboard/chart-data?bulan=${bulan}` : `/dashboard/chart-data`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.nama_produk);
                        const values = data.map(item => item.jumlah_pesanan);

                        if (chartProduk) chartProduk.destroy();

                        chartProduk = new Chart(ctxProduk, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Jumlah Pesanan',
                                    data: values,
                                    fill: false,
                                    borderColor: '#4e73df',
                                    tension: 0.2,
                                    pointBackgroundColor: '#4e73df',
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Jumlah Pesanan Setiap Produk'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1,
                                            callback: function(value) {
                                                return Number.isInteger(value) ? value : null;
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: 'Jumlah Pesanan'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Nama Produk'
                                        }
                                    }
                                }
                            }
                        });
                    });
            }

            // Chart jumlah pesanan harian
            const ctxHarian = document.getElementById('chartHarian').getContext('2d');
            let chartHarian;

            function fetchChartHarian(bulan = '') {
                const url = bulan ? `/dashboard/chart-data-harian?bulan=${bulan}` : `/dashboard/chart-data-harian`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.tanggal_pengambilan);
                        const values = data.map(item => item.jumlah_pesanan);

                        if (chartHarian) chartHarian.destroy();

                        chartHarian = new Chart(ctxHarian, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Total Pesanan Harian',
                                    data: values,
                                    backgroundColor: '#1cc88a',
                                    borderColor: '#17a673',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Jumlah Pesanan Harian'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Jumlah Pesanan'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Tanggal Pengambilan'
                                        }
                                    }
                                }
                            }
                        });
                    });
            }


            // Produk favorit
            function fetchProdukFavorit(bulan = '') {
                const url = bulan ? `/dashboard/produk-favorit?bulan=${bulan}` : `/dashboard/produk-favorit`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const favoritText = data ?
                            `${data.nama_produk} (dipesan ${data.jumlah_pesanan} kali)` :
                            'Tidak ada data';
                        document.getElementById('produkFavoritText').textContent = favoritText;
                    })
                    .catch(() => {
                        document.getElementById('produkFavoritText').textContent = 'Gagal memuat data';
                    });
            }


            // Load awal
            fetchChartData();
            fetchChartHarian();
            fetchProdukFavorit();

            // Saat filter bulan diganti
            bulanSelect.addEventListener('change', function() {
                const bulan = this.value;
                fetchChartData(bulan);
                fetchChartHarian(bulan);
                fetchProdukFavorit(bulan);
            });
        });
    </script>
@endsection
