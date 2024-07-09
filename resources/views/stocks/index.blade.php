<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Stock List') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('assets/css/stocks.css') }}">

    <?php
    if (!function_exists('formatRupiah')) {
        function formatRupiah($number)
        {
            return 'Rp ' . number_format($number, 0, ',', '.');
        }
    }
    ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h1>Stock List</h1>
            <a href="{{ route('stocks.create') }}" class="btn btn-primary">Add New Stock</a>
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Tipe Barang</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td>{{ $stock->nama_barang }}</td>
                        <td>{{ $stock->tipe_barang }}</td>
                        <td>{{ formatRupiah($stock->harga) }}</td>
                        <td>{{ $stock->quantity }}</td>
                        <td>
                            <a href="{{ route('stocks.edit', $stock) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('stocks.destroy', $stock) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
