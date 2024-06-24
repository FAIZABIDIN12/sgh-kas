<x-layout>
    <div class="container-fluid">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Data Kas Masuk dan Keluar BCA</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Uraian</th>
                                <th>Kas Masuk</th>
                                <th>Kas Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            $totalKasMasuk = 0;
                            $totalKasKeluar = 0;
                            @endphp

                            @foreach ($inCashs as $inCash)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $inCash->tanggal }}</td>
                                <td>{{ $inCash->uraian }}</td>
                                <td>{{ number_format($inCash->nominal, 2, ',', '.') }}</td>
                                <td>-</td>
                                @php
                                $totalKasMasuk += $inCash->nominal;
                                @endphp
                            </tr>
                            @endforeach

                            @foreach ($outCashs as $outCash)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $outCash->tanggal }}</td>
                                <td>{{ $outCash->uraian }}</td>
                                <td>-</td>
                                <td>{{ number_format($outCash->nominal, 2, ',', '.') }}</td>
                                @php
                                $totalKasKeluar += $outCash->nominal;
                                @endphp
                            </tr>
                            @endforeach

                            <tr>
                                <td colspan="3" class="fw-semibold text-end">Total</td>
                                <td>{{ number_format($totalKasMasuk, 2, ',', '.') }}</td>
                                <td>{{ number_format($totalKasKeluar, 2, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>