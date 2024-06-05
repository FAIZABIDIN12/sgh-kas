<x-layout>
    <div class="container-fluid">
        <div class="card bg-light border border-primary-subtle">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Form Kas Keluar FO</h3>
                    <button class="btn btn-success ti ti-plus" data-bs-toggle="modal" data-bs-target="#addJenisKeluarModal">Jenis Uang Keluar</button>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cashflows.storeKeluar') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="tgl" class="form-label">TGL:</label>
                                <input type="date" class="form-control" id="tgl" name="tanggal" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Uang Keluar:</label>
                                <select class="form-select" id="jenis" name="jenis" required>
                                    <option value="" selected disabled>Pilih jenis uang keluar</option>
                                    <option value="Operasional">Operasional</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="uraian" class="form-label">Uraian:</label>
                                <textarea class="form-control" id="uraian" name="uraian" rows="3" placeholder="Masukkan uraian" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="rp" class="form-label">Rp:</label>
                                <input type="text" class="form-control currency-input" id="rp" name="rp" placeholder="Masukkan jumlah dalam Rp." required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding new jenis uang keluar -->
    <div class="modal fade" id="addJenisKeluarModal" tabindex="-1" aria-labelledby="addJenisKeluarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addJenisKeluarModalLabel">Tambah Jenis Uang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addJenisKeluarForm">
                        <div class="mb-3">
                            <label for="newJenisKeluar" class="form-label">Jenis Uang Keluar Baru:</label>
                            <input type="text" class="form-control" id="newJenisKeluar" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
</x-layout>