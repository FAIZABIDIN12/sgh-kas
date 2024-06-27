<x-layout :title="'Cash Flow BCA'">
    <div class="container-fluid">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Cash Flow BCA</h3>
                </div>
                <div class="col-lg-2">
                    <div class="mb-2">Tanggal Awal:</div>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" id="min" name="min">
                        <label class="btn btn-primary input-group-text" for="min" placeholder="tanggal mulai"><i
                                class="ti ti-calendar"></i></label>
                    </div>
                    <div class="mb-2">Tanggal Akhir:</div>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" id="max" name="max">
                        <label class="btn btn-primary input-group-text" for="max" placeholder="tanggal akhir"><i
                                class="ti ti-calendar"></i></label>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="cashFlowTable" class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Uraian</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Saldo</th>
                                <th>FO</th>
                                @auth
                                @if (Auth::user()->role == 'admin')
                                <th class="text-center">Aksi</th>
                                @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @if ($cashFlows->isEmpty())
                            <div class="alert alert-warning">
                                Belum ada data.
                            </div>
                            @else
                            @foreach ($cashFlows->reverse() as $cashFlow)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $cashFlow->tanggal->format('d/m/Y') . ' ' .
                                    $cashFlow->created_at->format('H:i:s') }}</td>
                                <td>{{ $cashFlow->bcaCashType->jenis }}</td>
                                <td>{{ $cashFlow->uraian }}</td>
                                <td>{{ $cashFlow->bcaCashType->jenis === 'masuk' ? number_format($cashFlow->nominal, 0,
                                    ',',
                                    '.') : '-' }}</td>
                                <td>{{ $cashFlow->bcaCashType->jenis === 'keluar' ? number_format($cashFlow->nominal, 0,
                                    ',',
                                    '.') : '-' }}</td>
                                <td>{{ number_format($cashFlow->saldo, 0, ',', '.') }}</td>
                                <td>{{ $cashFlow->user->name }}</td>
                                @auth
                                @if (Auth::user()->role == 'admin')
                                <td>
                                    <form action="{{ route('bca_cashflows.destroy', $cashFlow->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="mb-1 btn btn-sm btn-danger"><i
                                                class="ti ti-trash"></i></button>
                                    </form>
                                    <a href="{{ route('bca_cashflows.edit', $cashFlow->id) }}"
                                        class="btn btn-sm btn-warning"><i class="ti ti-edit"></i></a>
                                </td>
                                @endif
                                @endauth
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
        <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>
        <script>
            $(document).ready( function () {
                var minDate, maxDate;
 
                DataTable.ext.search.push(function (settings, data, dataIndex) {
                    var min = minDate.val();
                    var max = maxDate.val();

                    min.setHours(0, 0, 0, 0)
                    max.setHours(0, 0, 0, 0)
                    
                    var strDate = data[1];
                    var parts = strDate.split(' ');

                    var dateParts = parts[0].split('/');

                    var day = parseInt(dateParts[0], 10);
                    var month = parseInt(dateParts[1], 10) - 1;
                    var year = parseInt(dateParts[2], 10);

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
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1;
                var yyyy = today.getFullYear();
                var formattedToday = (dd < 10 ? '0' + dd : dd) + '/' + (mm < 10 ? '0' + mm : mm) + '/' + yyyy;
                var formattedYesterday = (dd < 10 ? '0' + dd - 1 : dd - 1) + '/' + (mm < 10 ? '0' + mm : mm) + '/' + yyyy;
                
                minDate = new DateTime('#min', {
                    format: 'DD/MM/YYYY',
                });
                maxDate = new DateTime('#max', {
                    format: 'DD/MM/YYYY',
                });
                minDate.val(formattedYesterday);
                maxDate.val(formattedToday);
                
                var table = $('#cashFlowTable').DataTable();
                $('#cashFlowTable tbody').removeClass('d-none');
                
                $('#min, #max').on('change', function () {
                    table.draw();
                });
            } );       
        </script>
    </x-slot>
</x-layout>