<x-layout>


    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Import Cash Flow From Excel</h3>
                </div>
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="mb-3">
                    <form action="{{ route('cashflows.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>

                        <br>
                        <button class="btn btn-success"><i class="ti ti-file-spreadsheet"></i> Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layout>