@extends('admin.dashboard-admin')

@section('title', 'Data Hasil Prediksi')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Data Hasil Prediksi Stroke</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Prediksi</h6>
            <form action="{{ route('admin.hasil-prediksi') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari..." 
                           value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User ID</th>
                            <th>Usia</th>
                            <th>Hasil Prediksi</th>
                            <th>Tanggal Prediksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user_id ?? '-' }}</td>
                            <td>{{ $item->age ?? '-' }} tahun</td>
                            <td>
                                
                                <span class="badge {{ str_contains(strtolower($item->prediction ?? ''), 'beresiko') ? 'badge-danger' : 'badge-success' }}">
                                    {{ $item->prediction ?? 'Tidak ada data' }}
                                </span>
                            </td>
                            <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <button class="btn btn-info btn-sm view-detail" 
                                        data-toggle="modal" 
                                        data-target="#detailModal"
                                        data-detail="{{ json_encode($item) }}">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data prediksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Prediksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <!-- Detail akan diisi via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection