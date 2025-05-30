@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Konsultasi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Nama Pengguna:</strong> {{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}
                    </div>
                    <div class="mb-3">
                        <strong>Email Pengguna:</strong> {{ $konsultasi->pengguna->email ?? 'Tidak diketahui' }}
                    </div>
                    <div class="mb-3">
                        <strong>Identitas:</strong> {{ $konsultasi->identitas }}
                    </div>
                    <div class="mb-3">
                        <strong>Keluhan:</strong> {{ $konsultasi->keluhan }}
                    </div>
                    <div class="mb-3">
                        <strong>Tanggal Dibuat:</strong> {{ $konsultasi->created_at->format('d-m-Y H:i') }}
                    </div>
                    @if ($konsultasi->jawaban)
                        <div class="mb-3">
                            <strong>Jawaban:</strong> {{ $konsultasi->jawaban }}
                        </div>
                        <div class="mb-3">
                            <strong>Nama Pemberi Jawaban:</strong> {{ $konsultasi->nama_pemberi_jawaban }}
                        </div>
                        <div class="mb-3">
                            <strong>Status:</strong> <span class="badge badge-success">Selesai</span>
                        </div>
                    @else
                        <div class="mb-3">
                            <strong>Status:</strong> <span class="badge badge-warning">Pending (Menunggu Jawaban)</span>
                        </div>
                        <form id="replyForm" action="{{ route('admin.konsultasi.reply') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $konsultasi->_id }}">
                            <div class="form-group mb-3">
                                <label for="jawaban">Jawaban</label>
                                <textarea name="jawaban" id="jawaban" class="form-control @error('jawaban') is-invalid @enderror" rows="5">{{ old('jawaban') }}</textarea>
                                @error('jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama_pemberi_jawaban">Nama Pemberi Jawaban</label>
                                <input type="text" name="nama_pemberi_jawaban" id="nama_pemberi_jawaban" class="form-control @error('nama_pemberi_jawaban') is-invalid @enderror" value="{{ old('nama_pemberi_jawaban') }}">
                                @error('nama_pemberi_jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
                        </form>
                    @endif
                    <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('replyForm').addEventListener('submit', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Jawaban',
            text: 'Pastikan jawaban Anda sebelum Anda mengirim jawaban.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
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