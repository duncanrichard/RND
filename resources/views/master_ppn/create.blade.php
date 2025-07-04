@extends('layout.main')
@section('content')

<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Data PPN</h2>
        <form id="ppnForm" action="{{ route('master_ppn.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="ppn" class="block text-sm font-medium text-gray-700">PPN</label>
                    <input type="number" name="ppn" id="ppn" class="mt-1 block w-full border border-gray-300 rounded  shadow-sm py-2 px-3 sm:text-sm" min="0" required>
                </div>

                <div>
                    <label for="pph" class="block text-sm font-medium text-gray-700">PPH</label>
                    <input type="number" name="pph" id="pph" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 sm:text-sm" min="0" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kurs USD</label>
                    <input type="text" id="kurs_usd_display" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 sm:text-sm" readonly>
                    <input type="hidden" name="kurs_usd" id="kurs_usd">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kurs EURO</label>
                    <input type="text" id="kurs_euro_display" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 sm:text-sm" readonly>
                    <input type="hidden" name="kurs_euro" id="kurs_euro">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kurs YUAN</label>
                    <input type="text" id="kurs_yuan_display" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 sm:text-sm" readonly>
                    <input type="hidden" name="kurs_yuan" id="kurs_yuan">
                </div>

                <div>
                    <label for="additional_cost" class="block text-sm font-medium text-gray-700">Additional Cost</label>
                    <input type="number" name="additional_cost" id="additional_cost" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 sm:text-sm" min="0" required>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('master_ppn.index') }}" class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    fetch('/api/get-latest-exchange-rates')
        .then(response => response.json())
        .then(data => {
            document.getElementById('kurs_usd_display').value = data.kurs_usd;
            document.getElementById('kurs_usd').value = data.kurs_usd;

            document.getElementById('kurs_euro_display').value = data.kurs_euro;
            document.getElementById('kurs_euro').value = data.kurs_euro;

            document.getElementById('kurs_yuan_display').value = data.kurs_yuan;
            document.getElementById('kurs_yuan').value = data.kurs_yuan;
        });
});

</script>
@endsection
