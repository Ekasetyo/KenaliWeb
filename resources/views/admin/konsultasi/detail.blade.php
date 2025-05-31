@extends('admin.dashboard-admin')

@section('title', 'Detail Konsultasi')

@section('content')
    <div id="content">
        <div class="container-fluid">
            <!-- Header with back button -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-circle btn-light mr-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-comments text-primary mr-2"></i>Detail Konsultasi
                </h1>
            </div>

            <!-- Main content -->
            <div class="detail-container">
                <div class="row">
                    <!-- User Information Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100 border-left-primary">
                            <div class="card-header bg-white py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-user mr-2"></i>Informasi Pengguna
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="info-item mb-3">
                                    <div class="info-label">
                                        <i class="fas fa-user-circle text-primary mr-2"></i>
                                        <span class="font-weight-600">Nama konsultan:</span>
                                    </div>
                                    <div class="info-content">{{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}</div>
                                </div>
                                
                                <div class="info-item mb-3">
                                    <div class="info-label">
                                        <i class="fas fa-envelope text-primary mr-2"></i>
                                        <span class="font-weight-600">Email:</span>
                                    </div>
                                    <div class="info-content">{{ $konsultasi->pengguna->email ?? '-' }}</div>
                                </div>
                                
                                <div class="info-item mb-3">
                                    <div class="info-label">
                                        <i class="fas fa-id-card text-primary mr-2"></i>
                                        <span class="font-weight-600">Identitas:</span>
                                    </div>
                                    <div class="info-content">{{ $konsultasi->identitas ?? '-' }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-exclamation-circle text-primary mr-2"></i>
                                        <span class="font-weight-600">Keluhan:</span>
                                    </div>
                                    <div class="info-content">{{ $konsultasi->keluhan ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Information Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100 border-left-info">
                            <div class="card-header bg-white py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-info-circle mr-2"></i>Informasi Konsultasi
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="info-item mb-3">
                                    <div class="info-label">
                                        <i class="fas fa-comment text-primary mr-2"></i>
                                        <span class="font-weight-600">Jawaban:</span>
                                    </div>
                                    <div class="info-content">
                                        @if($konsultasi->jawaban)
                                            {{ $konsultasi->jawaban }}
                                        @else
                                            <span class="text-muted font-italic">Belum ada jawaban</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="info-item mb-3">
                                    <div class="info-label">
                                        <i class="fas fa-user-md text-primary mr-2"></i>
                                        <span class="font-weight-600">Nama Pemberi Jawaban:</span>
                                    </div>
                                    <div class="info-content">{{ $konsultasi->nama_pemberi_jawaban ?? '-' }}</div>
                                </div>
                                
                                <div class="info-item mb-3">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                        <span class="font-weight-600">Dibuat Pada:</span>
                                    </div>
                                    <div class="info-content">{{ $konsultasi->created_at->format('d M Y H:i') }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-check-circle text-primary mr-2"></i>
                                        <span class="font-weight-600">Status:</span>
                                    </div>
                                    <div class="info-content">
                                        <span class="badge badge-pill {{ $konsultasi->jawaban ? 'badge-success' : 'badge-warning' }}">
                                            {{ $konsultasi->jawaban ? 'Selesai' : 'Pending (Menunggu Jawaban)' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reply Form (if no answer yet) -->
                @if(!$konsultasi->jawaban)
                    <div class="card shadow-sm mt-4 border-top-primary">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-reply mr-2"></i>Berikan Jawaban
                            </h6>
                        </div>
                        <div class="card-body">
                            <form id="reply-form" action="{{ route('admin.konsultasi.reply') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $konsultasi->_id }}">
                                
                                <div class="form-group mb-4">
                                    <label for="jawaban" class="font-weight-600">
                                        <i class="fas fa-edit mr-2 text-primary"></i>Jawaban:
                                    </label>
                                    <textarea class="form-control @error('jawaban') is-invalid @enderror" 
                                        id="jawaban" name="jawaban" rows="5"
                                        placeholder="Tulis jawaban Anda secara detail..." required>{{ old('jawaban') }}</textarea>
                                    @error('jawaban')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label for="nama_pemberi_jawaban" class="font-weight-600">
                                        <i class="fas fa-signature mr-2 text-primary"></i>Nama Pemberi Jawaban:
                                    </label>
                                    <input type="text" class="form-control @error('nama_pemberi_jawaban') is-invalid @enderror"
                                        id="nama_pemberi_jawaban" name="nama_pemberi_jawaban" 
                                        placeholder="Masukkan nama Anda" required 
                                        value="{{ Auth::user()->name ?? old('nama_pemberi_jawaban') }}">
                                    @error('nama_pemberi_jawaban')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </a>
                                    <button type="button" class="btn btn-primary" onclick="confirmReply()">
                                        <i class="fas fa-paper-plane mr-2"></i>Kirim Jawaban
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="text-center mt-4">
                        <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Konsultasi
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom Styles */
        .detail-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .card {
            border-radius: 0.5rem;
            border: none;
        }
        
        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background-color: #f8f9fc;
        }
        
        .border-left-primary {
            border-left: 4px solid #4e73df;
        }
        
        .border-left-info {
            border-left: 4px solid #36b9cc;
        }
        
        .border-top-primary {
            border-top: 4px solid #4e73df;
        }
        
        .info-item {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
        }
        
        .info-label {
            width: 150px;
            display: flex;
            align-items: center;
            color: #5a5c69;
        }
        
        .info-content {
            flex: 1;
            min-width: 0;
            word-break: break-word;
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
        
        textarea.form-control {
            min-height: 150px;
            border: 1px solid #d1d3e2;
            transition: border-color 0.3s;
        }
        
        textarea.form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .badge-pill {
            padding: 0.5em 1em;
            font-size: 0.85rem;
        }
        
        .badge-success {
            background-color: #1cc88a;
        }
        
        .badge-warning {
            background-color: #f6c23e;
            color: #2a2a2a;
        }
        
        @media (max-width: 768px) {
            .info-item {
                flex-direction: column;
            }
            
            .info-label {
                width: 100%;
                margin-bottom: 0.25rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmReply() {
            Swal.fire({
                title: 'Kirim Jawaban?',
                text: 'Pastikan jawaban Anda sudah benar dan lengkap.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-paper-plane mr-2"></i>Ya, Kirim Sekarang',
                cancelButtonText: '<i class="fas fa-edit mr-2"></i>Periksa Lagi',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reply-form').submit();
                }
            });
        }

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