@extends('user.dashboard-user')

@section('title', 'Tambah Konsultasi')

@section('content')
    <style>
        .guide-card {
            background-color: #e9f7fe;
            border-left: 5px solid #2196F3;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .guide-card i {
            margin-right: 10px;
            color: #2196F3;
        }
    </style>
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Tambah Konsultasi</h1>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Konsultasi</h6>
                </div>
                <div class="card-body">
                    <div class="guide-card">
                        <h6><i class="fas fa-info-circle"></i> Panduan Pengisian Form Konsultasi</h6>
                        <p><strong>Identitas:</strong> Tulis identitas Anda dengan format seperti "Halo, nama saya [Nama Anda], saya berusia [Umur] tahun, jenis kelamin [L/P]", saya ingin bertanya. Contoh: "Halo, nama saya Budi, saya berusia 25 tahun, jenis kelamin Laki-laki."</p>
                        <p><strong>Keluhan:</strong> Jelaskan keluhan Anda secara rinci, termasuk gejala yang dirasakan, sejak kapan, dan faktor pemicunya jika ada. Contoh: "Saya mengalami demam tinggi sejak 3 hari lalu, disertai sakit kepala dan lemas."</p>
                    </div>
                    <form id="consultation-form" action="{{ route('konsultasi.store') }}" method="POST" onsubmit="return confirmSubmit()">
                        @csrf
                        <div class="form-group">
                            <label for="identitas">Identitas:</label>
                            <input type="text" class="form-control @error('identitas') is-invalid @enderror" id="identitas" name="identitas" placeholder="Masukkan identitas Anda (contoh: Halo, nama saya Budi, saya berusia 20 tahun)" required>
                            @error('identitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keluhan">Keluhan:</label>
                            <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="4" placeholder="Tulis keluhan Anda" required></textarea>
                            @error('keluhan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-right">
                            <a href="{{ route('konsultasi.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmSubmit() {
            Swal.fire({
                title: 'Konfirmasi Pengiriman',
                text: 'Pastikan isi konsultasi Anda telah sesuai, Anda tidak akan bisa mengubah isi konsultasi setelah dikirimkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('consultation-form').submit();
                }
            });
            return false;
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