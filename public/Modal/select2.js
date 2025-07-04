$(document).ready(function() {
    $('#tahun').select2({
        placeholder: "Pilih Tahun",
        width: '100%'
    });
});

$(document).ready(function() {
    $('#merk').select2({
        placeholder: "Pilih Merk",
        width: '100%',
        minimumInputLength: 3,
        allowClear: true,
        language: {
            inputTooShort: function () {
                return "Ketik minimal 3 karakter untuk mencari";
            },
            noResults: function () {
                return "Tidak ditemukan";
            },
            searching: function () {
                return "Mencari...";
            }
        }
    });

    // Trigger generate kode sample saat pilih merk dari Select2
    $('#merk').on('change', function () {
        const merk = $(this).val();

        if (merk) {
            fetch(`/generate-kode-sample?merk=${merk}`)
                .then(response => response.json())
                .then(data => {
                    const kodeSample = data.kode_sample;
                    const nomorFormula = `MFS/${kodeSample}`;
                    document.getElementById('kode_sample').value = kodeSample;
                    document.getElementById('nomor_formula').value = nomorFormula;
                })
                .catch(error => {
                    console.error('Error fetching kode sample:', error);
                    document.getElementById('kode_sample').value = '';
                    document.getElementById('nomor_formula').value = '';
                });
        } else {
            document.getElementById('kode_sample').value = '';
            document.getElementById('nomor_formula').value = '';
        }
    });
});

