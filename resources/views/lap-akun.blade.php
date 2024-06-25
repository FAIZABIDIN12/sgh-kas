<x-layout :title="'Laporan Akun'">
    <!-- Content -->
    <div class="container-fluid">
        <!-- Row 1 -->
        <div class="card">
            <div class="card-body">
                <h3 class="mb-0 px-6 py-10"><b>Laporan Akun</b></h3>
                <div class="px-6 py-6">
                    <label for="jenisFilter" class="form-label">Pilih Jenis</label>
                    <select class="form-control" data-live-search="true" id="jenisFilter">
                        <option value="all">Semua Jenis</option>
                        <option style="font-weight: bold;" disabled>---Uang Masuk---</option>
                        @if ($groupedCashTypes->has('masuk'))
                        @foreach ($groupedCashTypes['masuk'] as $cashType)
                        <option value="{{ $cashType->nama }}">{{ $cashType->nama }}</option>
                        @endforeach
                        @endif
                        <option style="font-weight: bold;" disabled>---Uang Keluar---</option>
                        @if ($groupedCashTypes->has('keluar'))
                        @foreach ($groupedCashTypes['keluar'] as $cashType)
                        <option value="{{ $cashType->nama }}">{{ $cashType->nama }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <!-- Button and Table Container -->
        <div class="d-flex justify-content-between align-items-center my-3">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-2">Tanggal Awal:</div>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" id="min" name="min">
                        <label class="btn btn-primary input-group-text" for="min" placeholder="tanggal mulai"><i
                                class="ti ti-calendar"></i></label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-2">Tanggal Akhir:</div>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" id="max" name="max">
                        <label class="btn btn-primary input-group-text" for="max" placeholder="tanggal akhir"><i
                                class="ti ti-calendar"></i></label>
                    </div>
                </div>

            </div>
            <button id="btnPrintExcel" class="btn btn-success btn-sm">
                Cetak Laporan Excel
            </button>
        </div>
        <table id="jenis-table" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>Uraian</th>
                    <th>Jenis</th>
                    <th>Kategori</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody class="d-none" id="reportTableBody">
                @if($transactions->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada data.
                    </td>
                </tr>
                @else
                @foreach ($transactions as $index => $transaction)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $transaction->uraian }}</td>
                    <td>{{ $transaction->cashType->jenis }}</td>
                    <td>{{ $transaction->cashType->nama }}</td>
                    <td>{{ number_format($transaction->nominal, 0, ',' , '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d/m/Y') }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>


    <x-slot name="scripts">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js">
        </script>
        <script>
            $(function() {
            $('#jenisFilter').selectpicker();
        });
        </script>
        <script>
            $(document).ready(function () {
                var table = $('#jenis-table').DataTable();
                $('#reportTableBody').removeClass('d-none');

                // Inisialisasi filter jenis
                document.getElementById('jenisFilter').addEventListener('change', function () {
                    var selectedJenis = this.value;
                    table.column(3).search(
                        selectedJenis === 'all' ? '' : selectedJenis,
                        true, false
                    ).draw();
                });

                // Tombol untuk mencetak ke Excel
                $('#btnPrintExcel').on('click', function () {
                    var selectedJenis = $('#jenisFilter').val();
                    var rowsData = table.rows({ search: 'applied' }).data();
                    console.log(rowsData);
                    var data = [
                        ['No', 'Uraian', 'Jenis', 'Kategori', 'Nominal', 'Tanggal']
                    ];

                    rowsData.each(function (rowData, index) {
                        var rowDataArray = [
                            rowData[0],  // Data kolom pertama
                            rowData[1],  // Data kolom kedua
                            rowData[2],  // Data kolom ketiga
                            rowData[3],  // Data kolom keempat
                            rowData[4],   // Data kolom kelima
                            rowData[5]   // Data kolom kelima
                        ];
                        data.push(rowDataArray);
                    });

                    var worksheet = XLSX.utils.aoa_to_sheet(data);
                    var workbook = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(workbook, worksheet, "Laporan Akun");

                    // Ambil tanggal hari ini
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = today.getFullYear();

                    var formattedDate = dd + '-' + mm + '-' + yyyy;

                    // Tentukan nama file
                    var fileName = 'Laporan_Akun_' + (selectedJenis === 'all' ? 'Semua' : selectedJenis) + '_' + formattedDate + '.xlsx';

                    XLSX.writeFile(workbook, fileName);
                });

                // Inisialisasi fungsi pencarian berdasarkan tanggal
                DataTable.ext.search.push(function (settings, data, dataIndex) {
                    var min = minDate.val();
                    var max = maxDate.val();
                    min.setHours(0, 0, 0, 0);
                    max.setHours(0, 0, 0, 0);

                    var strDate = data[5];

                    var parts = strDate.split('/');
                    var day = parseInt(parts[0], 10);
                    var month = parseInt(parts[1], 10) - 1;
                    var year = parseInt(parts[2], 10);

                    var date = new Date(year, month, day);

                    if (
                        (min === null && max === null) ||
                        (min === null && date <= max) ||
                        (min <= date && max === null) ||
                        (min <= date && date <= max)
                    ) {
                        return true;
                    }
                    return false;
                });

                // Inisialisasi tanggal
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1;
                var yyyy = today.getFullYear();

                var formattedToday = (dd < 10 ? '0' + dd : dd) + '/' + (mm < 10 ? '0' + mm : mm) + '/' + yyyy;
                var formattedYesterday = (dd < 10 ? '0' + (dd - 1) : dd - 1) + '/' + (mm < 10 ? '0' + mm : mm) + '/' + yyyy;

                minDate = new DateTime('#min', {
                    format: 'DD/MM/YYYY',
                });
                maxDate = new DateTime('#max', {
                    format: 'DD/MM/YYYY',
                });
                minDate.val(formattedYesterday);
                maxDate.val(formattedToday);

                // Event handler untuk perubahan tanggal
                $('#min, #max').on('change', function () {
                    table.draw();
                });

                // Memicu perubahan pada dropdown untuk memuat data awal
                $('#jenisFilter').trigger('change');
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
        <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>

    </x-slot>
</x-layout>