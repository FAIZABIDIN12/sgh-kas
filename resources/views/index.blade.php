<x-layout>
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
                    <tbody>
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
                            <td class="text-center">{{ $cashFlow->tanggal->format('d/m/Y') }}</td>
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
                                <form action="{{ route('cashFlow.destroy', $cashFlow->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="mb-1 btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                </form>
                                <a href="/edit-cash-flow/{{ $cashFlow->id }}" class="btn btn-sm btn-warning"><i class="ti ti-edit"></i></a>
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
            $(document).ready(function() {
                $('#cashFlowTable').DataTable();
            });
        </script>
    </x-slot>
</x-layout>