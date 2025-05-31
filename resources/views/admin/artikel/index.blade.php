@extends('admin.dashboard-admin')

@section('title', 'Data Artikel')

@section('content')
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Data Artikel</h1>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Artikel</h6>
                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formTambahArtikel">
                        <i class="fas fa-plus"></i> Tambah Artikel
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Penulis</th>
                                    <th>Sumber</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($artikels as $index => $artikel)
                                <tr>
                                    <td>{{ $artikels->firstItem() + $index }}</td>
                                    <td>{{ $artikel->judul }}</td>
                                    <td>{{ Str::limit($artikel->deskripsi, 100) }}</td>
                                    <td>{{ $artikel->penulis }}</td>
                                    <td>
                                        <a href="{{ $artikel->sumber }}" target="_blank" class="text-primary">
                                            <i class="fas fa-external-link-alt"></i> Kunjungi
                                        </a>
                                    </td>
                                    <td style="white-space: nowrap;">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.artikel.edit', $artikel->_id) }}" 
                                           class="btn btn-warning btn-sm mr-1">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form id="deleteForm-{{ $artikel->_id }}" 
                                              action="{{ route('admin.artikel.destroy', $artikel->_id) }}" 
                                              method="POST" 
                                              style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="confirmDelete('{{ $artikel->_id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $artikels->links() }}
                    </div>
                </div>
            </div>
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

    function confirmEdit(e, editUrl) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Edit',
            text: "Apakah Anda yakin ingin mengedit artikel ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Edit!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = editUrl;
            }
        });
    }
</script>
@endpush