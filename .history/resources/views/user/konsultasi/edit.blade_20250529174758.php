@extends('admin.dashboard-admin')

@section('title', 'Edit Konsultasi')

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Edit Konsultasi</h1>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Konsultasi</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('konsultasi.update', $konsultasi->_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="identitas">Identitas:</label>
                            <input type="text" class="form-control @error('identitas') is-invalid @enderror" id="identitas" name="identitas" value="{{ old('identitas', $konsultasi->identitas) }}" placeholder="Masukkan identitas Anda (contoh: Halo, nama saya Budi, saya berusia 20 tahun)" required>
                            @error('identitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keluhan">Keluhan:</label>
                            <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="4" placeholder="Tulis keluhan Anda" required>{{ old('keluhan', $konsultasi->keluhan) }}</textarea>
                            @error('keluhan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('konsultasi.show', $konsultasi->_id) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
@endpush