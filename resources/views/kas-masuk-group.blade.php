<x-layout>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-4 fw-semibold">Kas Masuk Tamu Group</h3>
                <div class="table-responsive">
                    <table id="groupTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Uraian</th>
                                <th class="text-center">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupCashFlows as $index => $cashFlow)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="">{{ $cashFlow->tanggal }}</td>
                                <td class="">{{ $cashFlow->cashType->nama }}</td>
                                <td>{{ $cashFlow->uraian }}</td>
                                <td class="text-end">{{ number_format($cashFlow->masuk, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Keterangan Total Kas Masuk -->
                <div class="card bg-warning-subtle mt-4">
                    <div class="row px-6 py-4">
                        <div class="col-md-6">
                            <h6><b>Total Kas Masuk Deposit</b>:</h6>
                            <p style="color: rgb(252, 27, 27);">Rp {{ number_format($totalDeposit, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><b>Total Kas Masuk Group</b>:</h6>
                            <p style="color: green;">Rp {{ number_format($totalPendapatan, 2) }}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>