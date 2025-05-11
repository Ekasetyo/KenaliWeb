@extends('admin.dashboard-admin')

@section('title', 'Data User')

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data User</h1>

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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $key => $user)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $user['name'] }}</td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>{{ $user['jenis_kelamin'] ?? '-' }}</td>
                                        <td>{{ $user['telepon'] ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $user['status'] == 'admin' ? 'badge-primary' : 'badge-secondary' }}">
                                                {{ ucfirst($user['status']) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-warning btn-sm btn-edit"
                                                data-id="{{ $user['_id'] }}" data-name="{{ $user['name'] }}"
                                                data-email="{{ $user['email'] }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $user['_id'] }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data user</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Input Data Master -->
        <!-- Modal Tambah Data User -->
        @include('admin.user.create')
        <!-- /.container-fluid -->

    <!-- End of Main Content -->
    </div>
@endsection