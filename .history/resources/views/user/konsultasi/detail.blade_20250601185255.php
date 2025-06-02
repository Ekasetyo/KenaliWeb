@extends('user.dashboard-user')

@section('title', 'Detail Konsultasi')

@section('content')
    <div id="content" class="bg-light">
        <div class="container-fluid">
            <!-- Header with back button -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('konsultasi.user.index') }}" class="btn btn-circle btn-light mr-3 shadow-sm">
                    <i class="fas fa-arrow-left text-primary"></i>
                </a>
                <h1 class="h4 mb-0 text-gray-800">
                    <i class="fas fa-comments text-primary mr-2"></i>Detail Konsultasi
                </h1>
            </div>

            <!-- Main content -->
            <div class="row">
                <!-- User Information Card -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center">
                                <i class="fas fa-user-circle mr-2"></i>Informasi Konsultan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-circle bg-primary-light mr-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Nama Konsultan</p>
                                    <p class="mb-0 font-weight-bold">{{ Session::get('user')['name'] ?? 'Tidak diketahui' }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-circle bg-primary-light mr-3">
                                    <i class="fas fa-id-card text-primary"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Identitas</p>
                                    <p class="mb-0 font-weight-bold">{{ $konsultasi->identitas ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="icon-circle bg-primary-light mr-3">
                                    <i class="fas fa-exclamation text-primary"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Keluhan</p>
                                    <p class="mb-0 font-weight-bold">{{ $konsultasi->keluhan ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Consultation Information Card -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center">
                                <i class="fas fa-info-circle mr-2"></i>Informasi Konsultasi
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-circle bg-info-light mr-3">
                                    <i class="fas fa-comment-dots text-info"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Jawaban</p>
                                    @if($konsultasi->jawaban)
                                        <p class="mb-0 font-weight-bold">{{ $konsultasi->jawaban }}</p>
                                    @else
                                        <p class="mb-0 font-italic text-muted">Sedang menunggu jawaban</p>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-circle bg-info-light mr-3">
                                    <i class="fas fa-user-md text-info"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Nama Pemberi Jawaban</p>
                                    <p class="mb-0 font-weight-bold">{{ $konsultasi->nama_pemberi_jawaban ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-circle bg-info-light mr-3">
                                    <i class="fas fa-calendar-alt text-info"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Dibuat Pada</p>
                                    <p class="mb-0 font-weight-bold">{{ $konsultasi->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="icon-circle bg-info-light mr-3">
                                    <i class="fas fa-check-circle text-info"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Status</p>
                                    <span class="badge badge-pill {{ $konsultasi->jawaban ? 'badge-success' : 'badge-warning' }}">
                                        {{ $konsultasi->jawaban ? 'Selesai' : 'Menunggu Jawaban' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                @if(!$konsultasi->jawaban)
                    <button type="button" class="btn btn-danger px-4 delete-btn">
                        <i class="fas fa-trash mr-2"></i>Hapus Konsultasi
                    </button>
                    <form action="{{ route('konsultasi.destroy', $konsultasi->_id) }}" method="POST" class="d-none" id="deleteForm">
                        @csrf
                        @method('DELETE')
                    </form>
                @else
                    <div></div> <!-- Empty div for spacing -->
                @endif
                <a href="{{ route('konsultasi.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom Styles */
        .bg-light {
            background-color: #f8f9fc !important;
        }
        
        .card {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.05);
        }
        
        .icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .bg-primary-light {
            background-color: rgba(78, 115, 223, 0.1);
        }
        
        .bg-info-light {
            background-color: rgba(23, 162, 184, 0.1);
        }
        
        .btn-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        
        .badge-pill {
            padding: 0.5em 1.25em;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        .badge-success {
            background-color: #1cc88a;
        }
        
        .badge-warning {
            background-color: #f6c23e;
            color: #2a2a2a;
        }
        
        .btn-outline-secondary {
            border-color: #d1d3e2;
        }
        
        .btn-outline-secondary:hover {
            background-color: #f8f9fc;
        }
        
        @media (max-width: 768px) {
            .card-body {
                padding: 1.25rem;
            }
            
            .icon-circle {
                width: 36px;
                height: 36px;
                font-size: 0.9rem;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column-reverse;
                gap: 1rem;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelector('.delete-btn')?.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Konsultasi?',
                html: `
                    <div class="text-left">
                        <p>Anda akan menghapus konsultasi ini:</p>
                        <div class="alert alert-light border mt-3 mb-0">
                            <p class="mb-1"><strong>Keluhan:</strong> {{ Str::limit($konsultasi->keluhan ?? '-', 100) }}</p>
                            <p class="mb-0"><strong>Tanggal:</strong> {{ $konsultasi->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <p class="mt-3 text-danger">Aksi ini tidak dapat dibatalkan!</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                reverseButtons: true,
                customClass: {
                    htmlContainer: 'text-left'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        });

        @if (session('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil!',
                html: `
                    <div class="text-center py-3">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                `,
                showConfirmButton: false,
                timer: 2000,
                background: '#f8f9fc'
            });
        @endif
        
        @if (session('error'))
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Gagal!',
                html: `
                    <div class="text-center py-3">
                        <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                `,
                showConfirmButton: false,
                timer: 2500,
                background: '#f8f9fc'
            });
        @endif
    </script>
@endpush