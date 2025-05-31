@extends('admin.dashboard-admin')

@section('title', 'Detail Konsultasi')

@section('content')
    <style>
        .detail-card {
            border-left: 5px solid #4e73df;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fc;
            border-radius: 5px;
        }
        .detail-card h6 {
            margin-bottom: 15px;
            color: #4e73df;
        }
        .detail-card p {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .detail-card i {
            margin-right: 10px;
            color: #858796;
        }
        .badge-primary {
            background-color: #4e73df;
        }
        .badge-secondary {
            background-color: #858796;
        }
    </style>
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Detail Konsultasi</h1>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Konsultasi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <h6>Informasi Pengguna</h6>
                                <p><i class="fas fa-user"></i> <strong>Nama Pelanggan:</strong> {{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}</p>
                                <p><i class="fas fa-envelope"></i> <strong>Email:</strong> {{ $konsultasi->pengguna->email ?? '-' }}</p>
                                <p><i class="fas fa-id-card"></i> <strong>Identitas:</strong> {{ $konsultasi->identitas ?? '-' }}</p>
                                <p><i class="fas fa-exclamation-circle"></i> <strong>Keluhan:</strong> {{ $konsultasi->keluhan ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <h6>Informasi Konsultasi</h6>
                                <p><i class="fas fa-comment"></i> <strong>Jawaban:</strong> {{ $konsultasi->jawaban ?? 'Belum ada jawaban' }}</p>
                                <p><i class="fas fa-user-md"></i> <strong>Nama Pemberi Jawaban:</strong> {{ $konsultasi->nama_pemberi_jawaban ?? '-' }}</p>
                                <p><i class="fas fa-calendar-alt"></i> <strong>Dibuat Pada:</strong> {{ $konsultasi->created_at->format('d M Y H:i') }}</p>
                                <p><i class="fas fa-info-circle"></i> <strong>Status:</strong>
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
                                <input type="text" class="form-control @error('nama_pemberi_jawaban') is-invalid @enderror" id="nama_pemberi_jawaban" name="nama_pemberi_jawaban" placeholder="Masukkan nama Anda" required value="{{ old('nama_pemberi_jawaban') }}">
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
                                <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    @else
                        <div class="text-right">
                            <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    @endif
                </div>
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