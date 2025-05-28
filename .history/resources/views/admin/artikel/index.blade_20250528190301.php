@extends('admin.dashboard-admin')

@section('title', 'Data Artikel')

@section('content')
    <div id="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <h1 class="h3 mb-2 text-gray-800">Data Artikel</h1>

            <!-- Sisanya tetap sama -->
            ...
        </div>
    </div>

    @include('admin.artikel.create')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(artikelId) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus artikel ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + artikelId).submit();
            }
        });
    }
</script>
@endpush