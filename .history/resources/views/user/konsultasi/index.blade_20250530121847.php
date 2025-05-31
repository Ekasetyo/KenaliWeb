@extends('user.dashboard-user')

@section('title', 'Konsultasi')

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Daftar Konsultasi</h1>
            <div class="row mb-3">
                <div class="col-md-6">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahKonsultasiModal">
                        <i class="fas fa-plus"></i> Tambah Konsultasi
                    </button>
                </div>
            </div>

            <!-- daftar tabel konsultasi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Konsultasi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Identitas</th>
                                    <th>Keluhan</th>
                                    <th>Jawaban</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftar_konsultasi as $index => $konsultasi)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}</td>
                                        <td>{{ $konsultasi->identitas ?? '-' }}</td>
                                        <td>{{ $konsultasi->keluhan ?? '-' }}</td>
                                        <td>{{ $konsultasi->jawaban ?? 'Sedang menunggu jawaban' }}</td>
                                        <td>
                                            <span class="badge {{ $konsultasi->jawaban ? 'badge-secondary' : 'badge-primary' }}">
                                                {{ $konsultasi->jawaban ? 'Selesai' : 'Aktif' }}
                                            </span>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <a href="{{ route('konsultasi.show', $konsultasi->_id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data konsultasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
@endpush