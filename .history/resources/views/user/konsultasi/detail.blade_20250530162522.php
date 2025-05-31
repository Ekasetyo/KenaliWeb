@extends('user.dashboard-user')

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
                                <p><i class="fas fa-user"></i> <strong>Nama:</strong> {{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}</p>
                                <p><i class="fas fa-id-card"></i> <strong>Identitas:</strong> {{ $konsultasi->identitas ?? '-' }}</p>
                                <p><i class="fas fa-exclamation-circle"></i> <strong>Keluhan:</strong> {{ $konsultasi->keluhan ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <h6>Informasi Konsultasi</h6>
                                <p><i class="fas fa-comment"></i> <strong>Jawaban:</strong> {{ $konsultasi->jawaban ?? 'Sedang menunggu jawaban' }}</p>
                                <p><i class="fas fa-user-md"></i> <strong>Nama Pemberi Jawaban:</strong> {{ $konsultasi->nama_pemberi_jawaban ?? '-' }}</p>
                                <p><i class="fas fa-calendar-alt"></i> <strong>Dibuat Pada:</strong> {{ $konsultasi->created_at->format('d M Y H:i') }}</p>
                                <p><i class="fas fa-info-circle"></i> <strong>Status:</strong>
                                    <span class="badge {{ $konsultasi->jawaban ? 'badge-secondary' : 'badge-primary' }}">
                                        {{ $konsultasi->jawaban ? 'Selesai' : 'Pending' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        @if (!$konsultasi->jawaban)
                            <form action="{{ route('konsultasi.destroy', $konsultasi->_id) }}" method="POST" style="display:inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-btn">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('konsultasi.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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