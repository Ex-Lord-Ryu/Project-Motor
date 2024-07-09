document.addEventListener('DOMContentLoaded', function () {
    const priceInput = document.getElementById('price');

    priceInput.addEventListener('input', function (e) {
        let value = priceInput.value.replace(/[^,\d]/g, '').toString();
        priceInput.value = formatRupiah(value);
    });

    function formatRupiah(value) {
        const split = value.split(',');
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
});