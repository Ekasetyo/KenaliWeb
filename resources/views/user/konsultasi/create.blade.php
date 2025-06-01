@extends('user.dashboard-user')

@section('title', 'Tambah Konsultasi')

@section('content')
    <div id="content" class="bg-light">
        <div class="container-fluid">
            <!-- Header with back button -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('konsultasi.index') }}" class="btn btn-circle btn-light mr-3 shadow-sm">
                    <i class="fas fa-arrow-left text-primary"></i>
                </a>
                <h1 class="h4 mb-0 text-gray-800">
                    <i class="fas fa-comment-medical text-primary mr-2"></i>Tambah Konsultasi
                </h1>
            </div>

            <!-- Main card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center">
                        <i class="fas fa-edit mr-2"></i>Form Konsultasi
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Guide card -->
                    <div class="guide-card bg-blue-50 border-left-blue p-4 mb-4 rounded">
                        <div class="d-flex">
                            <div class="icon-circle bg-blue-100 mr-3 flex-shrink-0">
                                <i class="fas fa-info-circle text-blue"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold text-blue mb-2">Panduan Pengisian Form Konsultasi</h6>
                                <div class="mb-3">
                                    <p class="font-weight-bold mb-1 text-dark">Identitas:</p>
                                    <p class="mb-0 text-muted small">Tulis identitas Anda dengan format seperti "Halo, nama saya [Nama Anda], saya berusia [Umur] tahun, jenis kelamin [L/P], saya ingin berkonsultasi untuk diri saya sendiri/orang lain".</p>
                                    <p class="mb-0 text-muted small font-italic">Contoh: "Halo, nama saya Budi, saya berusia 25 tahun, jenis kelamin Laki-laki, Saya ingin berkonsultasi untuk diri saya sendiri/orang tua saya."</p>
                                </div>
                                <div>
                                    <p class="font-weight-bold mb-1 text-dark">Keluhan:</p>
                                    <p class="mb-0 text-muted small">Jelaskan keluhan Anda secara rinci, beserta hasil deteksi yang sudah di lakukan di aplikasi mobile.</p>
                                    <p class="mb-0 text-muted small font-italic">Contoh: "Saya sudah melakukan deteksi dini untuk saya sendiri/orang tua/orang lain pada aplikasi kenali selama 1 bulan dengan hasil deteksi beresiko terkena stroke. Dalam 2 minggu pertama saya mengalami gejala seperti kepala terasa berat dan sering terasa lelah. Namun 2 minggu terakhir gejala itu mulai hilang namun kadang-kadang kembali lagi. Apa yang harus saya lakukan? apakah gejala tersebut menjadi tanda saya terkena stroke?"</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Consultation form -->
                    <form id="consultation-form" action="{{ route('konsultasi.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label for="identitas" class="font-weight-bold text-gray-700">
                                <i class="fas fa-id-card text-primary mr-2"></i>Identitas
                            </label>
                            <input type="text" class="form-control @error('identitas') is-invalid @enderror"
                                id="identitas" name="identitas"
                                placeholder="Masukkan identitas Anda (contoh: Halo, nama saya Budi, saya berusia 20 tahun)"
                                required>
                            @error('identitas')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="keluhan" class="font-weight-bold text-gray-700">
                                <i class="fas fa-comment-medical text-primary mr-2"></i>Keluhan
                            </label>
                            <textarea class="form-control @error('keluhan') is-invalid @enderror" 
                                id="keluhan" name="keluhan" rows="5"
                                placeholder="Tulis keluhan Anda secara detail" required></textarea>
                            @error('keluhan')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('konsultasi.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button type="button" class="btn btn-primary px-4" onclick="confirmSubmit()">
                                <i class="fas fa-paper-plane mr-2"></i>Kirim Konsultasi
                            </button>
                        </div>
                    </form>
                </div>
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
        }
        
        .icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .bg-blue-50 {
            background-color: #ebf5ff;
        }
        
        .border-left-blue {
            border-left: 4px solid #3490dc;
        }
        
        .text-blue {
            color: #3490dc;
        }
        
        .bg-blue-100 {
            background-color: #d6e9ff;
        }
        
        .guide-card {
            transition: all 0.3s ease;
        }
        
        .guide-card:hover {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        textarea.form-control {
            min-height: 150px;
            border: 1px solid #e3e6f0;
            transition: all 0.3s;
        }
        
        textarea.form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1);
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
            }
            
            .guide-card {
                padding: 1rem !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmSubmit() {
            const identitas = document.getElementById('identitas').value;
            const keluhan = document.getElementById('keluhan').value;
            
            Swal.fire({
                title: 'Konfirmasi Pengiriman',
                html: `
                    <div class="text-left">
                        <p>Pastikan data konsultasi Anda sudah benar:</p>
                        <div class="alert alert-light border mt-3 mb-0">
                            <p class="mb-1"><strong>Identitas:</strong> ${identitas.substring(0, 50)}${identitas.length > 50 ? '...' : ''}</p>
                            <p class="mb-0"><strong>Keluhan:</strong> ${keluhan.substring(0, 50)}${keluhan.length > 50 ? '...' : ''}</p>
                        </div>
                        <p class="mt-3 text-muted small">Anda tidak akan bisa mengubah isi konsultasi setelah dikirimkan.</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Kirim Sekarang',
                cancelButtonText: '<i class="fas fa-edit mr-2"></i>Periksa Lagi',
                reverseButtons: true,
                customClass: {
                    htmlContainer: 'text-left'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('consultation-form').submit();
                }
            });
        }

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