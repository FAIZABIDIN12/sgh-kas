<x-layout>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Edit Cash Flow</h3>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cashFlow.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="tgl" class="form-label">Tanggal:</label>
                                <input type="date" class="form-control" id="tgl" name="tanggal"
                                    value="{{ $data->tanggal }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Kategori:</label>
                                <select class="form-control" data-live-search="true" id="jenis" name="jenis"
                                    required>
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    @if ($cashTypes->isNotEmpty())
                                        @foreach ($cashTypes as $cashType)
                                            <option data-tokens="{{ $cashType->id }}" value="{{ $cashType->id }}"
                                                {{ $data->cashType->id == $cashType->id ? 'selected' : '' }}>
                                                {{ $cashType->nama }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="uraian" class="form-label">Uraian:</label>
                                <textarea type="text" class="form-control" id="uraian" name="uraian"
                                    placeholder="Masukkan nama contoh: operasional, dll" required>{{ $data->uraian }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="rp" class="form-label">Nominal:</label>
                                <input type="text" class="form-control currency-input" id="rp" name="rp"
                                    placeholder="Masukkan jumlah dalam Rp." required
                                    value="Rp.{{ number_format($data->nominal, 0, ',', '.') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
        <script>
            $(function() {
                $('#jenis').selectpicker();
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const today = new Date().toISOString().split('T')[0];
                const tglInput = document.getElementById('tgl');
                tglInput.value = today;
            });

            function formatCurrency(value) {
                value = value.replace(/[^,\d]/g, '');
                const [integerPart] = value.split(',');
                const formattedIntegerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                return formattedIntegerPart;
            }

            document.getElementById('rp').addEventListener('input', function(e) {
                const value = e.target.value;
                e.target.value = 'Rp.' + formatCurrency(value);
            });

            document.getElementById('rp').addEventListener('focus', function(e) {
                e.target.value = e.target.value.replace('Rp.', '').replace(/\./g, '');
            });

            document.getElementById('rp').addEventListener('blur', function(e) {
                const value = e.target.value;
                e.target.value = 'Rp.' + formatCurrency(value);
            });
        </script>
    </x-slot>
</x-layout>
