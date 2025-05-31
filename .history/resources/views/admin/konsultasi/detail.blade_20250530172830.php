@extends('admin.dashboard-admin')

@section('title', 'Detail Konsultasi')

@section('content')
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Detail Konsultasi</h1>
            <div class="detail-container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-card">
                            <h6><i class="fas fa-user"></i> Informasi Pengguna</h6>
                            <p><i class="fas fa-user-circle label-icon"></i> <strong>Nama konsultan:</strong> <span
                                    class="text-content">{{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}</span></p>
                            <p><i class="fas fa-envelope label-icon"></i> <strong>Email:</strong> <span
                                    class="text-content">{{ $konsultasi->pengguna->email ?? '-' }}</span></p>
                            <p><i class="fas fa-id-card label-icon"></i> <strong>Identitas:</strong> <span
                                    class="text-content">{{ $konsultasi->identitas ?? '-' }}</span></p>
                            <p><i class="fas fa-exclamation-circle label-icon"></i> <strong>Keluhan:</strong> <span
                                    class="text-content">{{ $konsultasi->keluhan ?? '-' }}</span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <h6><i class="fas fa-info-circle"></i> Informasi Konsultasi</h6>
                            <p><i class="fas fa-comment label-icon"></i> <strong>Jawaban:</strong> <span
                                    class="text-content">{{ $konsultasi->jawaban ?? 'Belum ada jawaban' }}</span></p>
                            <p><i class="fas fa-user-md label-icon"></i> <strong>Nama Pemberi Jawaban:</strong> <span
                                    class="text-content">{{ $konsultasi->nama_pemberi_jawaban ?? '-' }}</span></p>
                            <p><i class="fas fa-calendar-alt label-icon"></i> <strong>Dibuat Pada:</strong> <span
                                    class="text-content">{{ $konsultasi->created_at->format('d M Y H:i') }}</span></p>
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
                            <textarea class="form-control @error('jawaban') is-invalid @enderror" id="jawaban" name="jawaban" rows="4"
                                placeholder="Tulis jawaban Anda" required>{{ old('jawaban') }}</textarea>
                            @error('jawaban')
                                <div class="invalid-feedback">
                                    {{ $errors->first('jawaban') }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_pemberi_jawaban">Nama Pemberi Jawaban:</label>
                            <input type="text" class="form-control @error('nama_pemberi_jawaban') is-invalid @enderror"
                                id="nama_pemberi_jawaban" name="nama_pemberi_jawaban" placeholder="Masukkan nama Anda"
                                required value="{{ Auth::user()->name ?? '' }}">
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
