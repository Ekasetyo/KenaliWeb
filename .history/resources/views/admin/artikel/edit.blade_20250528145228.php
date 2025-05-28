@extends('admin.dashboard-admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Artikel</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Artikel</h6>
        </div>
        <div class="card-body">
            <form id="editArtikelForm" action="{{ route('admin.artikel.update', $artikel->_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" value="{{ $artikel->judul }}" 
                           class="form-control @error('judul') is-invalid @enderror" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                              rows="5" required>{{ $artikel->deskripsi }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="penulis" value="{{ $artikel->penulis }}" 
                           class="form-control @error('penulis') is-invalid @enderror" required>
                    @error('penulis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Sumber (URL)</label>
                    <input type="url" name="sumber" value="{{ $artikel->sumber }}" 
                           class="form-control @error('sumber') is-invalid @enderror" required>
                    @error('sumber')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-right">
                    <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary" onclick="return confirmSubmit()">
                        <i class="fas fa-save"></i> Update Artikel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmSubmit() {
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Update',
            text: "Apakah Anda yakin ingin menyimpan perubahan?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('editArtikelForm').submit();
            }
        });
    }
</script>
@endpush