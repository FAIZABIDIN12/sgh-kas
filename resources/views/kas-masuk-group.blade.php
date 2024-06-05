<x-layout>
    <div class="container-fluid">
        <div class="py-6 px-6 bg-light border border-primary-subtle rounded-2">
            <h3 class="mb-4 text-left"><b>Kas Masuk Tamu Group</b></h3>
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
                            <td class="">{{ $cashFlow->jenis }}</td>
                            <td>{{ $cashFlow->uraian }}</td>
                            <td class="text-end">{{ number_format($cashFlow->masuk, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Keterangan Total Kas Masuk -->
            <div class="card bg-primary-subtle mt-4">
                <div class="row px-6 py-4">
                    <div class="col-md-6">
                        <h6><b>Total Kas Masuk Deposit</b>:</h6>
                        <p style="color: rgb(252, 27, 27);">Rp {{ number_format($totalDeposit, 2) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><b>Total Kas Masuk Group</b>:</h6>
                        <p style="color: green;">Rp {{ number_format($totalDeposit + $totalPendapatan, 2) }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#groupTable').DataTable();
        });
    </script>
</x-layout>