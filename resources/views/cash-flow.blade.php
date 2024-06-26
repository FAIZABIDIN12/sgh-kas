<x-layout :title="'Cash Flow Front Office'">
    <!-- Content -->
    <div class="container-fluid">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-body">

                <h2 class="card-title fw-semibold mb-4">Kas Masuk & Keluar</h2>
                {{-- <div class="mb-3 d-flex">
                    <form method="GET" action="{{ route('dashboard') }}">
                        <select class="form-select" name="perPage" id="perPage" onchange="this.form.submit()">
                            <option value="10" {{ request('perPage')==10 ? 'selected' : '' }}>10</option>
                            <option value="100" {{ request('perPage')==100 ? 'selected' : '' }}>100</option>
                            <option value="1000" {{ request('perPage')==1000 ? 'selected' : '' }}>1000</option>
                        </select>
                    </form>
                </div> --}}
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
                    <table id="cashFlowTable" class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Uraian</th>
                                <th class="text-center">Masuk</th>
                                <th class="text-center">Keluar</th>
                                <th class="text-center">Saldo</th>
                                <th class="text-center">FO</th>
                                @auth
                                @if (Auth::user()->role == 'admin')
                                <th class="text-center">Aksi</th>
                                @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="d-none">
                            @if ($cashFlows->isEmpty())
                            <div class="alert alert-warning">
                                Belum ada data.
                            </div>
                            @else
                            @php
                            $saldo = 0;
                            @endphp
                            @foreach ($cashFlows->reverse() as $cashFlow)
                            @php
                            if ($cashFlow->cashType->jenis === 'masuk') {
                            $saldo += $cashFlow->nominal;
                            } else {
                            $saldo -= $cashFlow->nominal;
                            }
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                {{-- <td class="text-center">{{ $cashFlow->created_at->format('d/m/Y H:i:s') }}</td>
                                --}}
                                <td class="text-center">{{ $cashFlow->tanggal->format('d/m/Y') . ' ' .
                                    $cashFlow->created_at->format('H:i:s') }}</td>
                                <td class="">{{ $cashFlow->cashType->nama }}</td>
                                <td>{{ $cashFlow->uraian }}</td>
                                <td class="text-end">
                                    {{ $cashFlow->cashType->jenis === 'masuk' ? number_format($cashFlow->nominal, 0,
                                    ',', '.') :
                                    '-' }}
                                </td>
                                <td class="text-end">
                                    {{ $cashFlow->cashType->jenis === 'keluar' ? number_format($cashFlow->nominal, 0,
                                    ',', '.') :
                                    '-' }}
                                </td>
                                <td class="text-end">{{ number_format($cashFlow->saldo,0, ',', '.') }}</td>
                                <td>{{ $cashFlow->user->name }}</td>
                                @auth
                                @if (Auth::user()->role == 'admin')
                                <td>
                                    <form action="{{ route('cashFlow.destroy', $cashFlow->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="mb-1 btn btn-sm btn-danger"><i
                                                class="ti ti-trash"></i></button>
                                    </form>
                                    <a href="/edit-cash-flow/{{ $cashFlow->id }}" class="btn btn-sm btn-warning"><i
                                            class="ti ti-edit"></i></a>
                                </td>
                                @endif
                                @endauth
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{-- {{ $cashFlows->appends(['perPage' => request('perPage')])->links() }} --}}
                    </div>
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