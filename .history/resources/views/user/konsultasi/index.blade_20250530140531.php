@extends('user.dashboard-user')

@section('title', 'Konsultasi')

@section('content')
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Daftar Konsultasi</h1>
            <div class="alert alert-warning-custom">
                <strong>Perhatian:</strong> Konsultasi yang telah dibalas tidak dapat dihapus.
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status-filter">Filter Status</label>
                        <select class="form-control" id="status-filter" name="status">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Jawaban
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="date-filter">Filter Tanggal</label>
                        <input type="date" class="form-control" id="date-filter" name="date"
                            value="{{ request('date') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search">Cari Konsultasi</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Cari..."
                                value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="applyFilters()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mt-4">
                        <a href="{{ route('konsultasi.create') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-plus"></i> Tambah Konsultasi
                        </a>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Konsultasi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th style="width: 20%;">Identitas</th>
                                    <th style="width: 25%;">Keluhan</th>
                                    <th style="width: 15%;">Jawaban</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftar_konsultasi as $index => $konsultasi)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="text-ellipsis">{{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}
                                        </td>
                                        <td class="text-ellipsis">{{ $konsultasi->identitas ?? '-' }}</td>
                                        <td class="text-ellipsis">{{ $konsultasi->keluhan ?? '-' }}</td>
                                        <td class="text-ellipsis">{{ $konsultasi->jawaban ?? 'Sedang menunggu jawaban' }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $konsultasi->jawaban ? 'badge-secondary' : 'badge-primary' }}">
                                                {{ $konsultasi->jawaban ? 'Selesai' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <a href="{{ route('konsultasi.show', $konsultasi->_id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            @if (!$konsultasi->jawaban)
                                                <form action="{{ route('konsultasi.destroy', $konsultasi->_id) }}"
                                                    method="POST" style="display:inline;" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
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
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function applyFilters() {
            const status = document.getElementById('status-filter').value;
            const date = document.getElementById('date-filter').value;
            const search = document.getElementById('search').value;

            const url = new URL(window.location.href);
            url.searchParams.set('status', status);
            if (date) url.searchParams.set('date', date);
            else url.searchParams.delete('date');
            if (search) url.searchParams.set('search', search);
            else url.searchParams.delete('search');

            window.location.href = url.toString();
        }

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Pembatalan',
                    text: 'Apa Anda yakin ingin membatalkan konsultasi ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>
@endpush
