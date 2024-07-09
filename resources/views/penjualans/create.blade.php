<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Penjualan') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('assets/css/create.css') }}">

    <div class="container">
        <div class="h1">
            <h1>Tambah Penjualan</h1>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('penjualans.store') }}" method="POST" id="form-penjualan">
            @csrf
            <div class="form-group">
                <label for="nama_pembeli">Nama Pembeli</label>
                <input type="text" class="form-control @error('nama_pembeli') is-invalid @enderror" id="nama_pembeli" name="nama_pembeli" required>
                @error('nama_pembeli')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" required>
                @error('alamat')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="contoh: nama@gmail.com" required>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="no_telp">No Telp</label>
                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" placeholder="contoh: +6281234567890 atau 082123456789" required>
                @error('no_telp')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="tgl_jual">Tanggal Jual</label>
                <input type="date" class="form-control @error('tgl_jual') is-invalid @enderror" id="tgl_jual" name="tgl_jual" required>
                @error('tgl_jual')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div id="barang-fields">
                <div class="barang-field">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <select class="form-control @error('nama_barang.*') is-invalid @enderror" name="nama_barang[]" required>
                            <option value="">Pilih Barang</option>
                            @foreach($stocks as $stock)
                                <option value="{{ $stock->nama_barang }}" data-tipe="{{ $stock->tipe_barang }}" data-harga="{{ number_format($stock->harga, 0, ',', '.') }}">
                                    {{ $stock->nama_barang }} - {{ $stock->tipe_barang }} - Rp{{ number_format($stock->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('nama_barang.*')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tipe_barang">Tipe Barang</label>
                        <input type="text" class="form-control tipe-barang-input @error('tipe_barang.*') is-invalid @enderror" name="tipe_barang[]" required readonly>
                        @error('tipe_barang.*')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="text" class="form-control harga-input @error('harga.*') is-invalid @enderror" name="harga[]" required readonly>
                        @error('harga.*')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="diskon">Diskon (Rp)</label>
                        <input type="text" class="form-control diskon-input @error('diskon.*') is-invalid @enderror" name="diskon[]" required>
                        @error('diskon.*')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control quantity-input @error('quantity.*') is-invalid @enderror" name="quantity[]" required>
                        @error('quantity.*')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="total_harga">Total Harga (Rp)</label>
                        <input type="text" class="form-control total-harga-input" name="total_harga[]" required readonly>
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
            <a href="{{ route('penjualans.index') }}" class="btn btn-secondary btn-block">Kembali ke Daftar Penjualan</a>
        </form>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barangFields = document.getElementById('barang-fields');
        const addBarangBtn = document.getElementById('add-barang');
        const stockOptions = @json($stocks);

        function calculateTotalHarga(harga, diskon, quantity) {
            const hargaNumber = parseInt(harga.replace(/\./g, '')) || 0;
            const diskonNumber = parseInt(diskon.replace(/\./g, '')) || 0;
            const quantityNumber = parseInt(quantity) || 0;
            const totalHarga = (hargaNumber * quantityNumber) - diskonNumber;
            return totalHarga.toLocaleString('id-ID');
        }

        function formatRupiah(angka) {
            const numberString = angka.toString().replace(/[^,\d]/g, '').toString();
            const split = numberString.split(',');
            const sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            const ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            
            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            
            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        function addBarangField() {
            const newField = document.createElement('div');
            newField.classList.add('barang-field');
            newField.innerHTML = `
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <select class="form-control @error('nama_barang.*') is-invalid @enderror" name="nama_barang[]" required>
                        <option value="">Pilih Barang</option>
                        ${stockOptions.map(stock => `<option value="${stock.nama_barang}" data-tipe="${stock.tipe_barang}" data-harga="${stock.harga}">${stock.nama_barang} - ${stock.tipe_barang} - Rp${formatRupiah(stock.harga)}</option>`).join('')}
                    </select>
                    @error('nama_barang.*')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="tipe_barang">Tipe Barang</label>
                    <input type="text" class="form-control tipe-barang-input @error('tipe_barang.*') is-invalid @enderror" name="tipe_barang[]" required readonly>
                    @error('tipe_barang.*')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="harga">Harga (Rp)</label>
                    <input type="text" class="form-control harga-input @error('harga.*') is-invalid @enderror" name="harga[]" required readonly>
                    @error('harga.*')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="diskon">Diskon (Rp)</label>
                    <input type="text" class="form-control diskon-input @error('diskon.*') is-invalid @enderror" name="diskon[]" required>
                    @error('diskon.*')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control quantity-input @error('quantity.*') is-invalid @enderror" name="quantity[]" required>
                    @error('quantity.*')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
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
            const namaBarangSelect = newField.querySelector('select[name="nama_barang[]"]');
            const tipeBarangInput = newField.querySelector('input[name="tipe_barang[]"]');
            const hargaInput = newField.querySelector('input[name="harga[]"]');
            const diskonInput = newField.querySelector('input[name="diskon[]"]');
            const quantityInput = newField.querySelector('input[name="quantity[]"]');
            const totalHargaInput = newField.querySelector('input[name="total_harga[]"]');

            namaBarangSelect.addEventListener('change', function() {
                const selectedOption = namaBarangSelect.options[namaBarangSelect.selectedIndex];
                tipeBarangInput.value = selectedOption.getAttribute('data-tipe');
                hargaInput.value = formatRupiah(selectedOption.getAttribute('data-harga'));
                calculateAndSetTotalHarga();
            });

            diskonInput.addEventListener('input', function () {
                diskonInput.value = formatRupiah(diskonInput.value.replace(/\D/g, ''));
                calculateAndSetTotalHarga();
            });

            quantityInput.addEventListener('input', calculateAndSetTotalHarga);

            function calculateAndSetTotalHarga() {
                const harga = hargaInput.value.replace(/\./g, '');
                const diskon = diskonInput.value.replace(/\./g, '');
                const quantity = quantityInput.value;
                const totalHarga = calculateTotalHarga(harga, diskon, quantity);
                totalHargaInput.value = formatRupiah(totalHarga);
            }

            newField.querySelector('.remove-barang').addEventListener('click', function() {
                newField.remove();
            });
        }

        addBarangBtn.addEventListener('click', addBarangField);

        // Add initial event listeners for the existing fields
        const initialNamaBarangSelects = document.querySelectorAll('select[name="nama_barang[]"]');
        const initialDiskonInputs = document.querySelectorAll('input[name="diskon[]"]');
        const initialQuantityInputs = document.querySelectorAll('input[name="quantity[]"]');

        initialNamaBarangSelects.forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = select.options[select.selectedIndex];
                const parentField = select.closest('.barang-field');
                parentField.querySelector('input[name="tipe_barang[]"]').value = selectedOption.getAttribute('data-tipe');
                parentField.querySelector('input[name="harga[]"]').value = formatRupiah(selectedOption.getAttribute('data-harga'));
                calculateAndSetTotalHarga(parentField);
            });
        });

        initialDiskonInputs.forEach(input => {
            input.addEventListener('input', function() {
                const parentField = input.closest('.barang-field');
                input.value = formatRupiah(input.value.replace(/\D/g, ''));
                calculateAndSetTotalHarga(parentField);
            });
        });

        initialQuantityInputs.forEach(input => {
            input.addEventListener('input', function() {
                const parentField = input.closest('.barang-field');
                calculateAndSetTotalHarga(parentField);
            });
        });

        function calculateAndSetTotalHarga(parentField) {
            const harga = parentField.querySelector('input[name="harga[]"]').value.replace(/\./g, '');
            const diskon = parentField.querySelector('input[name="diskon[]"]').value.replace(/\./g, '');
            const quantity = parentField.querySelector('input[name="quantity[]"]').value;
            const totalHarga = calculateTotalHarga(harga, diskon, quantity);
            parentField.querySelector('input[name="total_harga[]"]').value = formatRupiah(totalHarga);
        }
    });
</script>
