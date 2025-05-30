@extends('admin.dashboard-admin')

@section('title', 'Detail Konsultasi')

@section('content')
    <style>
        .detail-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .info-card {
            background-color: #f8f9fc;
            border-left: 4px solid #2e7d32;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .info-card h6 {
            color: #2e7d32;
            font-size: 1.1rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .info-card i {
            margin-right: 8px;
            color: #2e7d32;
        }
        .info-card p {
            margin-bottom: 10px;
            font-size: 0.95rem;
            color: #333;
            display: flex;
            align-items: flex-start;
            text-align: justify; /* Mengatur teks menjadi justify */
        }
        .info-card .text-content {
            max-width: 100%;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: normal; /* Mengganti break-all menjadi normal untuk mencegah pemotongan kata */
            flex-grow: 1; /* Membuat teks memenuhi ruang yang tersedia */
            padding-left: 8px; /* Jarak dari ikon */
            line-height: 1.5; /* Menambahkan jarak antar baris untuk keterbacaan */
        }
        .info-card .text-ellipsis {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
        }
        .info-card .label-icon {
            width: 20px;
            margin-right: 10px;
            color: #666;
            flex-shrink: 0;
        }
        .badge {
            padding: 6px 12px;
            font-size: 0.9rem;
            border-radius: 12px;
        }
        .badge-primary {
            background-color: #2e7d32;
            color: #fff;
        }
        .badge-secondary {
            background-color: #6c757d;
            color: #fff;
        }
        .btn-custom {
            margin-left: 10px;
        }
    </style>
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Detail Konsultasi</h1>
            <div class="detail-container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-card">
                            <h6><i class="fas fa-user"></i> Informasi Pengguna</h6>
                            <p><i class="fas fa-user-circle label-icon"></i> <strong>Nama konsultan:</strong> <span class="text-content">{{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}</span></p>
                            <p><i class="fas fa-envelope label-icon"></i> <strong>Email:</strong> <span class="text-content">{{ $konsultasi->pengguna->email ?? '-' }}</span></p>
                            <p><i class="fas fa-id-card label-icon"></i> <strong>Identitas:</strong> <span class="text-content">{{ $konsultasi->identitas ?? '-' }}</span></p>
                            <p><i class="fas fa-exclamation-circle label-icon"></i> <strong>Keluhan:</strong> <span class="text-content">{{ $konsultasi->keluhan ?? '-' }}</span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <h6><i class="fas fa-info-circle"></i> Informasi Konsultasi</h6>
                            <p><i class="fas fa-comment label-icon"></i> <strong>Jawaban:</strong> <span class="text-content">{{ $konsultasi->jawaban ?? 'Belum ada jawaban' }}</span></p>
                            <p><i class="fas fa-user-md label-icon"></i> <strong>Nama Pemberi Jawaban:</strong> <span class="text-content">{{ $konsultasi->nama_pemberi_jawaban ?? '-' }}</span></p>
                            <p><i class="fas fa-calendar-alt label-icon"></i> <strong>Dibuat Pada:</strong> <span class="text-content">{{ $konsultasi->created_at->format('d M Y H:i') }}</span></p>
                            <p><i class="fas fa-check-circle label-icon"></i> <strong>Status:</strong>
                                <span class="badge {{ $konsultasi->jawaban ? 'badge-secondary' : 'badge-primary' }}">
                                    {{ $konsultasi->jawaban ? 'Selesai' : 'Pending (Menunggu Jawaban)' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                @if (!$konsultasi->jawaban)
                    <form id="reply-form" action="{{ route('admin.konsultasi.reply') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="id" value="{{ $konsultasi->_id }}">
                        <div class="form-group">
                            <label for="jawaban">Jawaban:</label>
                            <textarea class="form-control @error('jawaban') is-invalid @enderror" id="jawaban" name="jawaban" rows="4" placeholder="Tulis jawaban Anda" required>{{ old('jawaban') }}</textarea>
                            @error('jawaban')
                                <div class="invalid-feedback">
                                    {{ $errors->first('jawaban') }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_pemberi_jawaban">Nama Pemberi Jawaban:</label>
                            <input type="text" class="form-control @error('nama_pemberi_jawaban') is-invalid @enderror" id="nama_pemberi_jawaban" name="nama_pemberi_jawaban" placeholder="Masukkan nama Anda" required value="{{ Auth::user()->name ?? '' }}">
                            @error('nama_pemberi_jawaban')
                                <div class="invalid-feedback">
                                    {{ $errors->first('nama_pemberi_jawaban') }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary mr-2" onclick="confirmReply()">
                                <i class="fas fa-paper-plane"></i> Kirim
                            </button>
                            <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-secondary btn-custom">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                @else
                    <div class="text-right mt-4">
                        <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-secondary btn-custom">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmReply() {
            Swal.fire({
                title: 'Konfirmasi Jawaban',
                text: 'Pastikan jawaban Anda telah sesuai sebelum mengirim.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reply-form').submit();
                }
            });
        }

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