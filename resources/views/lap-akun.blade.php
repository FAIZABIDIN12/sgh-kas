<x-layout>
    <!-- Content -->
    <div class="container-fluid">
        <!--  Row 1 -->
        <div class="card">
            <div class="card-body">
                <h3 class="mb-0 px-6 py-10"><b>Laporan Akun</b></h3>
                <div class="px-6 py-6">
                    <label for="jenisFilter" class="form-label">Pilih Jenis</label>
                    <select id="jenisFilter" class="form-select">
                        <option value="all">Semua Jenis</option>
                        <option style="font-weight: bold;" disabled>---Uang Masuk---</option>
                        <option value="WIG Payment">WIG Payment</option>
                        <option value="DP Tamu Group">DP Tamu Group</option>
                        <option value="Pendapatan Payment Group">Pendapatan Payment Group</option>
                        <option value="Pendapatan OOD Renang">Pendapatan OOD Renang</option>
                        <option value="Pendapatan OOD Toko">Pendapatan OOD Toko</option>
                        <option value="Pendapatan OOD Loundry">Pendapatan OOD Loundry</option>
                        <option value="Non Pendapatan">Non Pendapatan</option>
                        <option style="font-weight: bold;" disabled>---Uang Keluar---</option>
                        <option value="Operasional">Operasional</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Akun</th>
                    <th>Jenis</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody id="reportTableBody">
                @foreach ($transactions as $index => $transaction)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $transaction->uraian }}</td>
                    <td>{{ $transaction->jenis }}</td>
                    <td class="text-center">{{ number_format($transaction->masuk + $transaction->keluar, 2) }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('jenisFilter').addEventListener('change', function() {
            var selectedJenis = this.value;
            var tableBody = document.getElementById('reportTableBody');

            // Ambil data dari tabel
            var rows = Array.from(document.querySelectorAll('#reportTableBody tr'));

            // Tampilkan/hilangkan baris sesuai jenis yang dipilih
            rows.forEach(function(row) {
                var jenis = row.cells[2].innerText;
                if (selectedJenis === 'all' || jenis === selectedJenis) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Memicu perubahan pada dropdown untuk memuat data awal
        document.getElementById('jenisFilter').dispatchEvent(new Event('change'));
    </script>
</x-layout>