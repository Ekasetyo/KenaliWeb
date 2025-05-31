@extends('user.dashboard-user')

@section('title', 'Data Hasil Deteksi')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Data Hasil Deteksi</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Deteksi</h6>
            <form action="{{ route('user.riwayat-deteksi') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama pengguna..." 
                           value="{{ htmlspecialchars(request('search')) }}">
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
                            <th>Nama</th>
                            <th>Usia</th>
                            <th>Hasil Deteksi</th>
                            <th>Tanggal Deteksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name ?? '-' }}</td>
                            <td>{{ is_numeric($item->age) ? $item->age . ' tahun' : $item->age }}</td>
                            <td>
                                <span class="badge {{ str_contains(strtolower($item->prediction ?? ''), 'beresiko') ? 'badge-danger' : 'badge-success' }}">
                                    {{ $item->prediction ?? 'Tidak ada data' }}
                                </span>
                            </td>
                            <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-info btn-sm view-detail mr-1" 
                                            data-toggle="modal" 
                                            data-target="#detailModal"
                                            data-detail="{{ htmlspecialchars(json_encode($item)) }}">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                    <form action="{{ route('user.riwayat-deteksi.delete', ['id' => $item->_id]) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data Deteksi</td>
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
@endsection