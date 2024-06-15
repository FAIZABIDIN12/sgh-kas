<x-layout>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Tambah Jenis Kas</h3>
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
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('typecash.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Kas:</label>
                                <select class="form-select" id="jenis" name="jenis" required>
                                    <option value="" selected disabled>Pilih jenis kas (masuk/keluar)</option>
                                    <option value="masuk" {{ old('jenis')=='masuk' ? 'selected' : '' }}>Masuk
                                    </option>
                                    <option value="keluar" {{ old('jenis')=='masuk' ? 'selected' : '' }}>Keluar
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Kategori:</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Masukkan nama contoh: operasional, dll" value="{{ old('nama') }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan:</label>
                                <textarea type="text" class="form-control" id="keterangan" name="keterangan"
                                    placeholder="masukkan keterangan" required>{{ old('keterangan') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Import From Excel</h3>
                </div>
                <div class="mb-3">
                    <form action="{{ route('typecash.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>

                        <br>
                        <button class="btn btn-success"><i class="ti ti-file-spreadsheet"></i> Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Daftar Jenis Kas</h3>
                </div>
                @if ($cashTypes->isEmpty())
                <div class="alert alert-warning">
                    Belum ada data.
                </div>
                @else
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Jenis</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Keterangan</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Edit</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cashTypes as $i => $cashType)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $cashTypes->firstItem() + $i }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{{ $cashType->nama }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        {!! $cashType->jenis == 'masuk'
                                        ? '<span class="badge bg-success rounded-3 fw-semibold">Masuk</span>'
                                        : '<span class="badge bg-danger rounded-3 fw-semibold">Keluar</span>' !!}
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{{ $cashType->keterangan }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <form action="{{ route('typecash.destroy', $cashType->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                class="ti ti-trash"></i></button>
                                    </form>
                                    <a href="/edit-jenis-kas/{{ $cashType->id }}" class="btn btn-sm btn-warning"><i
                                            class="ti ti-edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $cashTypes->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>


    <!-- Modal for adding new jenis uang keluar -->
    <div class="modal fade" id="addJenisKeluarModal" tabindex="-1" aria-labelledby="addJenisKeluarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addJenisKeluarModalLabel">Tambah Jenis Uang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addJenisKeluarForm">
                        <div class="mb-3">
                            <label for="newJenisKeluar" class="form-label">Jenis Uang Keluar Baru:</label>
                            <input type="text" class="form-control" id="newJenisKeluar" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>