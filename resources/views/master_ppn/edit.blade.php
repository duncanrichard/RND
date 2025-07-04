@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Data PPN</h2>
        <form id="editPpnForm" action="{{ route('master_ppn.update', $master_ppn->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="ppn" class="block text-sm font-medium text-gray-700">PPN</label>
                    <input type="number" name="ppn" id="ppn" value="{{ $master_ppn->ppn }}" min="0"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           placeholder="%" required>
                </div>
                <br>
                <div>
                    <label for="pph" class="block text-sm font-medium text-gray-700">PPH</label>
                    <input type="number" name="pph" id="pph" value="{{ $master_ppn->pph }}" min="0"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           placeholder="%" required>
                </div>
                <br>
                <div>
                <label for="kurs_rupiah_display" class="block text-sm font-medium text-gray-700">KURS RUPIAH</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-500"></span>
                        <input type="text" id="kurs_rupiah_display" value="{{ number_format($master_ppn->kurs_rupiah, 0, ',', '.') }}" 
                               class="pl-10 mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                               placeholder="500000" required readonly>
                        <input type="hidden" name="kurs_rupiah" id="kurs_rupiah_hidden" value="{{ $master_ppn->kurs_rupiah }}"> <!-- Field tersembunyi -->
                    </div>
                </div>
                <br>
                <div>
                    <label for="kurs_usd" class="block text-sm font-medium text-gray-700">KURS USD$</label>
                    <input type="text" id="kurs_usd" value="{{ number_format($master_ppn->kurs_usd, 0, ',', '.') }}" 
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 bg-gray-100 focus:outline-none sm:text-sm" 
                           placeholder="500000" readonly>
                </div>

             
                <br>
                <div>
                    <label for="kurs_euro" class="block text-sm font-medium text-gray-700">KURS EURO</label>
                    <input type="text" id="kurs_euro" value="{{ number_format($master_ppn->kurs_euro, 0, ',', '.') }}" 
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 bg-gray-100 focus:outline-none sm:text-sm" 
                           placeholder="500000" readonly>
                </div>
                </div>
                <br>
                <div>
                    <label for="kurs_yuan_display" class="block text-sm font-medium text-gray-700">KURS YUAN</label>
                    <div class="relative">
                        <input type="text" id="kurs_yuan_display" value="{{ number_format($master_ppn->kurs_yuan, 0, ',', '.') }}" 
                               class="pl-10 mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                               placeholder="500000" required readonly>
                        <input type="hidden" name="kurs_yuan" id="kurs_yuan_hidden" value="{{ $master_ppn->kurs_yuan }}">
                    </div>
                </div>
                <br>
                <div>
                    <label for="additional_cost" class="block text-sm font-medium text-gray-700">Additional Cost</label>
                    <input type="number" name="additional_cost" min="0" id="additional_cost" value="{{ $master_ppn->additional_cost }}" 
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           placeholder="%" required>
                </div>
                <br>
            </div>
            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan
                </button>
                <a href="{{ route('master_ppn.index') }}" 
                   class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
    


document.addEventListener("DOMContentLoaded", function () {
    const formatCurrencyInput = (inputDisplay, inputHidden) => {
        inputDisplay.addEventListener("input", function () {
            let value = this.value.replace(/[^,\d]/g, ""); // Hapus karakter non-digit
            inputHidden.value = value; // Simpan nilai asli ke input hidden
            this.value = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            }).format(value).replace("Rp", "").trim(); // Format tampilan
        });
    };

    formatCurrencyInput(document.getElementById("kurs_usd_display"), document.getElementById("kurs_usd_hidden"));
    formatCurrencyInput(document.getElementById("kurs_euro_display"), document.getElementById("kurs_euro_hidden"));
    formatCurrencyInput(document.getElementById("kurs_yuan_display"), document.getElementById("kurs_yuan_hidden"));
    formatCurrencyInput(document.getElementById("kurs_rupiah_display"), document.getElementById("kurs_rupiah_hidden"));
});
</script>
