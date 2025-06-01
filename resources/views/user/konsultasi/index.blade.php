@extends('user.dashboard-user')

@section('title', 'Konsultasi')

@section('content')
    <div id="content">
        <div class="container-fluid">
            <!-- Header with icon and breadcrumb -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-comments text-primary mr-2"></i>Daftar Konsultasi
                </h1>
            </div>

            <!-- Alert notification -->
            <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle mr-3 fa-lg"></i>
                    <div>
                        <strong class="font-weight-bold">Perhatian:</strong> Konsultasi yang telah dibalas tidak dapat dihapus.
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Filter Section -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body py-3">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="form-group mb-0">
                                <label for="status-filter" class="font-weight-600 text-primary">
                                    <i class="fas fa-filter mr-2"></i>Status Konsultasi
                                </label>
                                <select class="form-control border-primary" id="status-filter" name="status">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Jawaban</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="form-group mb-0">
                                <label for="date-filter" class="font-weight-600 text-primary">
                                    <i class="fas fa-calendar-alt mr-2"></i>Filter Tanggal
                                </label>
                                <input type="date" class="form-control border-primary" id="date-filter" name="date"
                                    value="{{ request('date') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label for="search" class="font-weight-600 text-primary">
                                    <i class="fas fa-search mr-2"></i>Cari Konsultasi
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control border-primary" id="search" name="search" 
                                        placeholder="Cari konsultasi..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="applyFilters()">
                                            <i class="fas fa-filter"></i> Terapkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consultation Table -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-center border-0">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <i class="fas fa-sync-alt text-muted mr-2"></i>
                        <small class="text-muted">Refresh browser secara berkala untuk pembaharuan</small>
                    </div>
                    <a href="{{ route('konsultasi.create') }}" class="btn btn-primary btn-icon-split">
                        <span class="icon">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Konsultasi</span>
                    </a>
                </div>
                <div class="card-body px-0 pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0" style="width: 5%;">No</th>
                                    <th class="border-0" style="width: 15%;">Nama</th>
                                    <th class="border-0" style="width: 20%;">Identitas</th>
                                    <th class="border-0" style="width: 25%;">Keluhan</th>
                                    <th class="border-0" style="width: 15%;">Jawaban</th>
                                    <th class="border-0" style="width: 10%;">Status</th>
                                    <th class="border-0" style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftar_konsultasi as $index => $konsultasi)
                                    <tr class="border-bottom">
                                        <td class="align-middle">{{ $index + 1 }}</td>
                                        <td class="align-middle text-ellipsis">
                                            <i class="fas fa-user-circle mr-2 text-primary"></i>
                                            {{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}
                                        </td>
                                        <td class="align-middle text-ellipsis">{{ $konsultasi->identitas ?? '-' }}</td>
                                        <td class="align-middle text-ellipsis">{{ $konsultasi->keluhan ?? '-' }}</td>
                                        <td class="align-middle text-ellipsis">
                                            @if($konsultasi->jawaban)
                                                {{ $konsultasi->jawaban }}
                                            @else
                                                <span class="text-muted">Sedang menunggu jawaban</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-pill {{ $konsultasi->jawaban ? 'badge-success' : 'badge-warning' }}">
                                                {{ $konsultasi->jawaban ? 'Selesai' : 'Menunggu' }}
                                            </span>
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap;">
                                            <a href="{{ route('konsultasi.show', $konsultasi->_id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill mr-1">
                                                <i class="fas fa-eye mr-1"></i> Detail
                                            </a>
                                            @if (!$konsultasi->jawaban)
                                                <form action="{{ route('konsultasi.destroy', $konsultasi->_id) }}"
                                                    method="POST" style="display:inline;" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill delete-btn">
                                                        <i class="fas fa-trash mr-1"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">Tidak ada data konsultasi</h5>
                                                <a href="{{ route('konsultasi.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus mr-2"></i>Buat Konsultasi Baru
                                                </a>
                                            </div>
                                        </td>
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

@push('styles')
    <style>
        /* Custom Styles */
        .card {
            border-radius: 0.5rem;
            border: none;
        }
        
        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .alert-warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            color: #856404;
        }
        
        .border-primary {
            border-color: #4e73df !important;
        }
        
        .table th {
            font-weight: 600;
            color: #4e73df;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .badge-pill {
            padding: 0.5em 0.8em;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-success {
            background-color: #1cc88a;
        }
        
        .badge-warning {
            background-color: #f6c23e;
            color: #2a2a2a;
        }
        
        .text-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
        
        .empty-state {
            opacity: 0.7;
        }
        
        .btn-icon-split {
            padding: 0.375rem 0.75rem;
        }
        
        .btn-icon-split .icon {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem;
            margin-right: 0.5rem;
            background-color: rgba(255,255,255,0.2);
            border-radius: 0.25rem;
        }
        
        @media (max-width: 768px) {
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
            
            .table-responsive {
                border: none;
            }
        }
    </style>
@endpush

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
                    html: '<div class="text-center"><i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i><p>Apa Anda yakin ingin membatalkan konsultasi ini?</p></div>',
                    showCancelButton: true,
                    confirmButtonColor: '#e74a3b',
                    cancelButtonColor: '#858796',
                    confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Batalkan',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Tidak',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });

        @if (session('success'))
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500,
                backdrop: false,
                background: '#f8f9fc',
                width: '400px'
            });
        @endif
        
        @if (session('error'))
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                backdrop: false,
                background: '#f8f9fc',
                width: '400px'
            });
        @endif
    </script>
@endpush