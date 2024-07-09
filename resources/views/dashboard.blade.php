<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .btn {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #4a76a8;
            color: white;
        }

        .btn-primary:hover {
            opacity: 0.8;
        }

        .data-table {
            display: none;
        }

        .data-table.active {
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>

    <?php
    if (!function_exists('formatRupiah')) {
        function formatRupiah($number)
        {
            return 'Rp ' . number_format($number, 0, ',', '.');
        }
    }
    ?>   

    <div class="container">
        <h1>Dashboard</h1>

        <div class="button-group">
            <button class="btn btn-primary" onclick="showData('daily')">Harian</button>
            <button class="btn btn-primary" onclick="showData('monthly')">Bulanan</button>
            <button class="btn btn-primary" onclick="showData('yearly')">Tahunan</button>
        </div>

        <div id="daily" class="data-table active">
            <h3>Penjualan Harian</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dailySales as $sale)
                        <tr>
                            <td>{{ date('Y-m-d', strtotime($sale->date)) }}</td>
                            <td>{{ formatRupiah($sale->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h3>Pembelian Harian</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Pembelian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dailyPurchases as $purchase)
                        <tr>
                            <td>{{ date('Y-m-d', strtotime($purchase->date)) }}</td>
                            <td>{{ formatRupiah($purchase->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="monthly" class="data-table">
            <h3>Penjualan Bulanan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Jumlah Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlySales as $sale)
                        <tr>
                            <td>{{ date('Y-m', strtotime($sale->date)) }}</td>
                            <td>{{ formatRupiah($sale->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h3>Pembelian Bulanan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Jumlah Pembelian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlyPurchases as $purchase)
                        <tr>
                            <td>{{ date('Y-m', strtotime($purchase->date)) }}</td>
                            <td>{{ formatRupiah($purchase->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="yearly" class="data-table">
            <h3>Penjualan Tahunan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Jumlah Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($yearlySales as $sale)
                        <tr>
                            <td>{{ date('Y', strtotime($sale->date)) }}</td>
                            <td>{{ formatRupiah($sale->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h3>Pembelian Tahunan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Jumlah Pembelian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($yearlyPurchases as $purchase)
                        <tr>
                            <td>{{ date('Y', strtotime($purchase->date)) }}</td>
                            <td>{{ formatRupiah($purchase->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showData(tableId) {
            const tables = document.querySelectorAll('.data-table');
            tables.forEach(table => {
                table.classList.remove('active');
            });
            document.getElementById(tableId).classList.add('active');
        }
    </script>
</x-app-layout>
