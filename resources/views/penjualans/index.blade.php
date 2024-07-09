<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Penjualan') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_penjualan.css') }}">

    <?php
    if (!function_exists('formatRupiah')) {
        function formatRupiah($number)
        {
            return 'Rp ' . number_format($number, 0, ',', '.');
        }
    }
    ?>

    <div class="container">
        <div class="h1">
            <h1>Penjualan</h1>
        </div>
        <a href="{{ route('penjualans.create') }}" class="btn btn-primary">Tambah Penjualan</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pembeli</th>
                    <th>Nama Barang</th>
                    <th>Tipe Barang</th>
                    <th>Tanggal Penjualan</th>
                    <th>QTY</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualans as $penjualan)
                    <tr>
                        <td>{{ $penjualan->id_jual }}</td>
                        <td>{{ $penjualan->nama_pembeli }}</td>
                        <td>{{ $penjualan->nama_barang }}</td>
                        <td>{{ $penjualan->tipe_barang }}</td>
                        <td>{{ $penjualan->tgl_jual }}</td>
                        <td>{{ $penjualan->quantity }}</td>
                        <td>{{ formatRupiah($penjualan->total_harga) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
