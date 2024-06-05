<x-layout>
    <!-- Content -->
    <div class="container-fluid">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="card bg-light">
            <div class="p-2 text-primary-emphasis bg-light border border-primary-subtle rounded-2">
                <h3 class="mb-3 text-left px-6 py-10"><b>Kas Masuk & Keluar</b></h3>
                <div class="table-responsive">
                    <table id="cashFlowTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Uraian</th>
                                <th class="text-center">Masuk</th>
                                <th class="text-center">Keluar</th>
                                <th class="text-center">Saldo</th>
                                <th class="text-center">FO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cashFlows as $cashFlow)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $cashFlow->tanggal }}</td>
                                <td class="">{{ $cashFlow->jenis }}</td>
                                <td>{{ $cashFlow->uraian }}</td>
                                <td class="text-end">{{ number_format($cashFlow->masuk, 2) }}</td>
                                <td class="text-end">{{ number_format($cashFlow->keluar, 2) }}</td>
                                <td class="text-end">{{ number_format($cashFlow->saldo, 2) }}</td>
                                <td>{{ $cashFlow->fo }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>