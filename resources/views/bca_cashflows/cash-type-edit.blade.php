<x-layout :title="'Edit Jenis Kas'">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Edit Jenis Kas (BCA) {{ $data->nama }}</h3>
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
                        <form action="{{ route('bca_cashflows.type.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Kas:</label>
                                <select class="form-select" id="jenis" name="jenis" required>
                                    <option value="" selected disabled>Pilih jenis kas (masuk/keluar)</option>
                                    <option value="masuk" {{ $data->jenis == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                    <option value="keluar" {{ $data->jenis == 'keluar' ? 'selected' : '' }}>Keluar
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="uraian" class="form-label">Nama Kategori:</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Masukkan nama contoh: operasional, dll" value="{{ $data->nama }}"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>