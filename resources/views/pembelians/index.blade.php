<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pembelian') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_pembelian.css') }}">

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
            <h1>Pembelian</h1>
        </div>
        <a href="{{ route('pembelians.create') }}" class="btn btn-primary">Tambah Pembelian</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Tipe Barang</th>
                    <th>Tanggal Pembelian</th>
                    <th>QTY</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelians as $pembelian)
                <tr>
                    <td>{{ $pembelian->id_beli }}</td>
                    <td>{{ $pembelian->nama_barang }}</td>
                    <td>{{ $pembelian->tipe_barang }}</td>
                    <td>{{ $pembelian->tgl_beli }}</td>
                    <td>{{ $pembelian->quantity }}</td>
                    <td>{{ formatRupiah($pembelian->total_harga) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>
