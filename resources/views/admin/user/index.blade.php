@extends('admin.dashboard-admin')

@section('title', 'Data User')

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data User</h1>

            <!-- Search Bar -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('admin.user.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari user..."
                                value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formTambahUser">
                        <i class="fas fa-plus"></i> Tambah User
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No Telepon</th>
                                    <th>Status</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $key => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $key }}</td>
                                        <td>{{ $user['name'] }}</td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>{{ $user['jenis_kelamin'] ?? '-' }}</td>
                                        <td>{{ $user['no_telepon'] ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $user['status'] == 'admin' ? 'badge-primary' : 'badge-secondary' }}">
                                                {{ ucfirst($user['status']) }}
                                            </span>
                                        </td>
                                        <td>{{ $user['alamat'] }}</td>
                                        <td style="white-space: nowrap;">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.user.edit', $user->_id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Tombol Delete -->
                                            <form id="deleteForm-{{ $user->_id }}"
                                                action="{{ route('admin.user.destroy', $user->_id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="_id" value="{{ $user->_id }}">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete('{{ $user->_id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data user</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Input Data Master -->
        <!-- Modal Tambah Data User -->
        @include('admin.user.create')
        <!-- /.container-fluid -->
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(userId) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus user ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + userId).submit();
                }
            });
        }
    </script>
@endpush
