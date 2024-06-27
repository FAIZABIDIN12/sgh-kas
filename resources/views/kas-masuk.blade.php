<x-layout :title="'Tambah Kas Masuk'">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Form Kas Masuk FO</h3>
                    {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addJenisModal">
                        <i class="ti ti-plus"></i>
                        Jenis Uang Masuk
                    </button> --}}
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cashflows.storeMasuk') }}" method="POST">
                            @csrf
                            @auth
                            @if (Auth::user()->role == 'admin')
                            <div class="mb-3">
                                <label for="tgl" class="form-label">Tanggal:</label>
                                <input type="date" class="form-control" id="tgl" name="tanggal" required>
                            </div>
                            @else
                            <div class="mb-3">
                                <label for="tgl" class="form-label">Tanggal:</label>
                                <input type="date" class="form-control" id="tgl" name="tanggal" required readonly>
                            </div>
                            @endif
                            @endauth
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Uang Masuk:</label>

                                <select class="form-control" data-live-search="true" id="jenis" name="jenis" required>
                                    <option value="" selected disabled>Pilih jenis uang masuk</option>
                                    @if ($inCashs->isNotEmpty())
                                    @foreach ($inCashs as $inCash)
                                    <option data-tokens="{{ $inCash->id }}" value="{{ $inCash->id }}">
                                        {{ $inCash->nama }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="uraian" class="form-label">Uraian:</label>
                                <textarea class="form-control" id="uraian" name="uraian" rows="3"
                                    placeholder="Masukkan uraian" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="rp" class="form-label">Nominal:</label>
                                <input type="text" class="form-control currency-input" id="rp" name="rp"
                                    placeholder="Masukkan jumlah dalam Rp." required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti-save-alt"></i> Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding new jenis uang masuk -->
    <div class="modal fade" id="addJenisModal" tabindex="-1" aria-labelledby="addJenisModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addJenisModalLabel">Tambah Jenis Uang Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addJenisForm">
                        <div class="mb-3">
                            <label for="newJenis" class="form-label">Jenis Uang Masuk Baru:</label>
                            <input type="text" class="form-control" id="newJenis" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js">
        </script>
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

                const addJenisForm = document.getElementById('addJenisForm');
                const jenisSelect = document.getElementById('jenis');

                addJenisForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const newJenisValue = document.getElementById('newJenis').value;

                    if (newJenisValue) {
                        const newOption = document.createElement('option');
                        newOption.value = newJenisValue;
                        newOption.textContent = newJenisValue;
                        newOption.selected = true;
                        jenisSelect.appendChild(newOption);

                        const addJenisModal = new bootstrap.Modal(document.getElementById('addJenisModal'));
                        addJenisModal.hide();

                        document.getElementById('newJenis').value = '';
                    }
                });
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