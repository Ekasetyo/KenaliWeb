@extends('admin.dashboard-admin')

@section('title', 'Detail Konsultasi')

@section('content')
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
                            <p><strong>Nama Pelanggan:</strong> {{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}</p>
                            <p><strong>Email:</strong> {{ $konsultasi->pengguna->email ?? '-' }}</p>
                            <p><strong>Identitas:</strong> {{ $konsultasi->identitas ?? '-' }}</p>
                            <p><strong>Keluhan:</strong> {{ $konsultasi->keluhan ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Jawaban:</strong> {{ $konsultasi->jawaban ?? 'Belum ada jawaban' }}</p>
                            <p><strong>Nama Pemberi Jawaban:</strong> {{ $konsultasi->nama_pemberi_jawaban ?? '-' }}</p>
                            <p><strong>Dibuat Pada:</strong> {{ $konsultasi->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge {{ $konsultasi->jawaban ? 'badge-secondary' : 'badge-primary' }}">
                                    {{ $konsultasi->jawaban ? 'Selesai' : 'Pending' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    @if (!$konsultasi->jawaban)
                        <form action="{{ route('admin.konsultasi.reply') }}" method="POST" onsubmit="return confirmReply()">
                            @csrf
                            <input type="hidden" name="id" value="{{ $konsultasi->_id }}">
                            <div class="form-group">
                                <label for="jawaban">Jawaban:</label>
                                <textarea class="form-control @error('jawaban') is-invalid @enderror" id="jawaban" name="jawaban" rows="4" placeholder="Tulis jawaban Anda" required>{{ old('jawaban') }}</textarea>
                                @error('jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nama_pemberi_jawaban">Nama Pemberi Jawaban:</label>
                                <input type="text" class="form-control @error('nama_pemberi_jawaban') is-invalid @enderror" id="nama_pemberi_jawaban" name="nama_pemberi_jawaban" placeholder="Masukkan nama Anda" required value="{{ old('nama_pemberi_jawaban') }}">
                                @error('nama_pemberi_jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary mr-2">
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
            return new Promise((resolve) => {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Pastikan jawaban Anda sebelum mengirim jawaban.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Kirim!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    resolve(result.isConfirmed);
                });
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