<x-layout>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Daftar User</h3>
                    {{-- <a class="btn btn-primary" href="/register"><i class="ti ti-plus"></i>Tambah User</a> --}}
                </div>
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @elseif (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
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
                @if($users->isEmpty())
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
                                    <h6 class="fw-semibold mb-0">Usename</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Email</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Role</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">#</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $i => $user)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $i+1 }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{{$user->name}}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{{$user->username}}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{{$user->email}}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{{$user->role}}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                    </form>
                                    <a href="/edit-user/{{$user->id}}" class="btn btn-sm btn-warning"><i class="ti ti-edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>


    <!-- Modal for adding new jenis uang keluar -->
    <div class="modal fade" id="addJenisKeluarModal" tabindex="-1" aria-labelledby="addJenisKeluarModalLabel" aria-hidden="true">
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