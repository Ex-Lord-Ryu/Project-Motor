<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Pembelian') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('assets/css/create.css') }}">

    <div class="container mt-4">
        <div class="h1">
            <h1>Tambah Pembelian</h1>
        </div>
        <form action="{{ route('pembelians.store') }}" method="POST" id="form-pembelian">
            @csrf
            <div class="form-group">
                <label for="nama_supplier">Nama Supplier</label>
                <input type="text" class="form-control @error('nama_supplier') is-invalid @enderror"
                    id="nama_supplier" name="nama_supplier" required>
                @error('nama_supplier')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                    name="alamat" required>
                @error('alamat')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" placeholder="contoh: nama@gmail.com" required>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="no_telp">No Telp</label>
                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp"
                    name="no_telp" placeholder="contoh: +6281234567890 atau 082123456789" required>
                @error('no_telp')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="tgl_beli">Tanggal Beli</label>
                <input type="date" class="form-control @error('tgl_beli') is-invalid @enderror" id="tgl_beli"
                    name="tgl_beli" required>
                @error('tgl_beli')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div id="barang-fields">
                <div class="barang-field">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control @error('nama_barang.*') is-invalid @enderror"
                            name="nama_barang[]" required>
                        @error('nama_barang.*')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tipe_barang">Tipe Barang</label>
                        <input type="text" class="form-control @error('tipe_barang.*') is-invalid @enderror"
                            name="tipe_barang[]" required>
                        @error('tipe_barang.*')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="text" class="form-control harga-input @error('harga.*') is-invalid @enderror"
                            name="harga[]" required>
                        @error('harga.*')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="diskon">Diskon (Rp)</label>
                        <input type="text" class="form-control diskon-input @error('diskon.*') is-invalid @enderror"
                            name="diskon[]" required>
                        @error('diskon.*')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number"
                            class="form-control quantity-input @error('quantity.*') is-invalid @enderror"
                            name="quantity[]" required>
                        @error('quantity.*')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="total_harga">Total Harga (Rp)</label>
                        <input type="text" class="form-control total-harga-input" name="total_harga[]" required
                            readonly>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-danger btn-sm remove-barang">Hapus</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-success" id="add-barang">Tambah Barang</button>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('pembelians.index') }}" class="btn btn-secondary btn-block">Kembali ke Daftar
                Pembelian</a>
        </form>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barangFields = document.getElementById('barang-fields');
        const addBarangBtn = document.getElementById('add-barang');

        function calculateTotalHarga(harga, diskon, quantity) {
            const hargaNumber = parseInt(harga.replace(/\./g, '')) || 0;
            const diskonNumber = parseInt(diskon.replace(/\./g, '')) || 0;
            const quantityNumber = parseInt(quantity) || 0;
            let totalHarga = (hargaNumber * quantityNumber) - diskonNumber;

            // Limit total harga to display in tens of thousands
            totalHarga = Math.floor(totalHarga / 10000) * 10000;

            return formatRupiah(totalHarga);
        }

        function formatRupiah(angka) {
            let number_string = angka.toString().replace(/[^,\d]/g, '');
            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        // Function to convert formatted number back to plain number
        function convertToNumber(rupiah) {
            return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
        }

        function addBarangField() {
            const newField = document.createElement('div');
            newField.classList.add('barang-field');
            newField.innerHTML = `
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" class="form-control" name="nama_barang[]" required>
                </div>
                <div class="form-group">
                    <label for="tipe_barang">Tipe Barang</label>
                    <input type="text" class="form-control" name="tipe_barang[]" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga (Rp)</label>
                    <input type="text" class="form-control harga-input" name="harga[]" required>
                </div>
                <div class="form-group">
                    <label for="diskon">Diskon (Rp)</label>
                    <input type="text" class="form-control diskon-input" name="diskon[]" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control quantity-input" name="quantity[]" required>
                </div>
                <div class="form-group">
                    <label for="total_harga">Total Harga (Rp)</label>
                    <input type="text" class="form-control total-harga-input" name="total_harga[]" required readonly>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-danger btn-sm remove-barang">Hapus</button>
                </div>
            `;
            barangFields.appendChild(newField);

            // Add event listeners for the new fields
            const hargaInputs = newField.querySelectorAll('input[name="harga[]"]');
            const diskonInputs = newField.querySelectorAll('input[name="diskon[]"]');
            const quantityInputs = newField.querySelectorAll('input[name="quantity[]"]');
            const totalHargaInputs = newField.querySelectorAll('input[name="total_harga[]"]');

            hargaInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = formatRupiah(convertToNumber(this.value));
                    const harga = input.value;
                    const diskon = input.closest('.barang-field').querySelector(
                        'input[name="diskon[]"]').value;
                    const quantity = input.closest('.barang-field').querySelector(
                        'input[name="quantity[]"]').value;
                    input.closest('.barang-field').querySelector('input[name="total_harga[]"]')
                        .value = calculateTotalHarga(harga, diskon, quantity);
                });
            });

            diskonInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = formatRupiah(convertToNumber(this.value));
                    const diskon = input.value;
                    const harga = input.closest('.barang-field').querySelector(
                        'input[name="harga[]"]').value;
                    const quantity = input.closest('.barang-field').querySelector(
                        'input[name="quantity[]"]').value;
                    input.closest('.barang-field').querySelector('input[name="total_harga[]"]')
                        .value = calculateTotalHarga(harga, diskon, quantity);
                });
            });

            quantityInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const quantity = input.value;
                    const harga = input.closest('.barang-field').querySelector(
                        'input[name="harga[]"]').value;
                    const diskon = input.closest('.barang-field').querySelector(
                        'input[name="diskon[]"]').value;
                    input.closest('.barang-field').querySelector('input[name="total_harga[]"]')
                        .value = calculateTotalHarga(harga, diskon, quantity);
                });
            });

            newField.querySelector('.remove-barang').addEventListener('click', function() {
                newField.remove();
            });
        }

        addBarangBtn.addEventListener('click', addBarangField);

        // Add initial event listeners for the existing fields
        const initialHargaInputs = document.querySelectorAll('.harga-input');
        const initialDiskonInputs = document.querySelectorAll('.diskon-input');
        const initialQuantityInputs = document.querySelectorAll('.quantity-input');

        initialHargaInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.value = formatRupiah(convertToNumber(this.value));
                const harga = input.value;
                const diskon = input.closest('.barang-field').querySelector('.diskon-input')
                    .value;
                const quantity = input.closest('.barang-field').querySelector('.quantity-input')
                    .value;
                input.closest('.barang-field').querySelector('.total-harga-input').value =
                    calculateTotalHarga(harga, diskon, quantity);
            });
        });

        initialDiskonInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.value = formatRupiah(convertToNumber(this.value));
                const diskon = input.value;
                const harga = input.closest('.barang-field').querySelector('.harga-input')
                .value;
                const quantity = input.closest('.barang-field').querySelector('.quantity-input')
                    .value;
                input.closest('.barang-field').querySelector('.total-harga-input').value =
                    calculateTotalHarga(harga, diskon, quantity);
            });
        });

        initialQuantityInputs.forEach(input => {
            input.addEventListener('input', function() {
                const quantity = input.value;
                const harga = input.closest('.barang-field').querySelector('.harga-input')
                .value;
                const diskon = input.closest('.barang-field').querySelector('.diskon-input')
                    .value;
                input.closest('.barang-field').querySelector('.total-harga-input').value =
                    calculateTotalHarga(harga, diskon, quantity);
            });
        });
    });
</script>

