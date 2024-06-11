<x-layout>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title fw-semibold">Edit User {{ $user->name }}</h3>
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
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama..." value="{{ $user->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan nama..." value="{{ $user->username }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan nama..." value="{{ $user->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role:</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="" selected disabled>Hak akses</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="fo" {{ $user->role == 'fo' ? 'selected' : '' }}>Front Office</option>
                                    <option value="accounting" {{ $user->role == 'accounting' ? 'selected' : '' }}>Accounting</option>
                                    <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>