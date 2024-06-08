<x-layout>
    <!-- Content -->
    <div class="container-fluid">
        <!-- Notification Section -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <!-- Row 1 -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0"><b>Laporan Invoice</b></h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">
                        <i class="ti ti-plus"></i> Tambah Data
                    </button>
                </div>

                <!-- Modal Form -->
                <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalFormLabel">Tambah Data Invoice</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form di sini -->
                                <form id="invoiceForm" action="{{ route('invoices.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="namaTamu" class="form-label">Nama Tamu</label>
                                        <input type="text" class="form-control" id="namaTamu" name="nama_tamu" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tglCheckin" class="form-label">Tanggal Checkin</label>
                                        <input type="date" class="form-control" id="tglCheckin" name="tgl_checkin" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tglCheckout" class="form-label">Tanggal Checkout</label>
                                        <input type="date" class="form-control" id="tglCheckout" name="tgl_checkout" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pax" class="form-label">Pax</label>
                                        <input type="number" class="form-control" id="pax" name="pax" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tagihan" class="form-label">Tagihan</label>
                                        <input type="text" class="form-control" id="tagihan" name="tagihan" placeholder="Rp." required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sp" class="form-label">SP</label>
                                        <input type="text" class="form-control" id="sp" name="sp" placeholder="Penanggung Jawab" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" form="invoiceForm" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="table-responsive">
                    <table id="invoiceTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Tamu</th>
                                <th>Tgl Checkin</th>
                                <th>Tgl Checkout</th>
                                <th>Pax</th>
                                <th>Tagihan</th>
                                <th>SP</th>
                                <th>FO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $invoice->nama_tamu }}</td>
                                <td>{{ $invoice->tgl_checkin }}</td>
                                <td>{{ $invoice->tgl_checkout }}</td>
                                <td>{{ $invoice->pax }}</td>
                                <td>Rp. {{ number_format($invoice->tagihan, 2) }}</td>
                                <td>{{ $invoice->sp }}</td>
                                <td>{{ $invoice->fo }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#invoiceTable').DataTable();
        });
    </script>
</x-layout>