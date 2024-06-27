<x-layout :title="'Kas Masuk BCA'">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Form Kas Masuk BCA</h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('bca_cashflows.storeMasuk') }}" method="POST">
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
                                <input type="text" class="form-control" id="rp" name="nominal"
                                    placeholder="Masukkan jumlah dalam Rp." required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti-save-alt"></i> Simpan
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const today = new Date().toISOString().split('T')[0];
                const tglInput = document.getElementById('tgl');
                tglInput.value = today;

                function formatCurrency(value) {
                    // Hanya format tampilan, hilangkan simbol 'Rp.' dan tanda titik dari nilai asli
                    return value.replace(/\D/g, '');
                }

                document.getElementById('rp').addEventListener('input', function(e) {
                    const value = e.target.value;
                    e.target.value = 'Rp.' + formatCurrency(value).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                });

                document.getElementById('rp').addEventListener('focus', function(e) {
                    e.target.value = e.target.value.replace('Rp.', '').replace(/\./g, '');
                });

                document.getElementById('rp').addEventListener('blur', function(e) {
                    const value = e.target.value;
                    e.target.value = 'Rp.' + formatCurrency(value).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                });
            });
        </script>
    </x-slot>
</x-layout>