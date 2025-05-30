@extends('.user')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Buat Konsultasi Baru</h5>
                </div>
                <div class="card-body">
                    <form id="konsultasiForm" action="{{ route('konsultasi.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="identitas">Identitas</label>
                            <input type="text" name="identitas" id="identitas" class="form-control @error('identitas') is-invalid @enderror" value="{{ old('identitas') }}">
                            @error('identitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="keluhan">Keluhan</label>
                            <textarea name="keluhan" id="keluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="5">{{ old('keluhan') }}</textarea>
                            @error('keluhan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Konsultasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('konsultasiForm').addEventListener('submit', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Pengiriman',
            text: 'Pastikan isi konsultasi Anda telah sesuai, Anda tidak akan bisa mengubah isi konsultasi Anda setelah dikirimkan.',
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
</script>
@endpush