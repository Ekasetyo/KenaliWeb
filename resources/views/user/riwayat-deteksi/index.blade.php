@extends('user.dashboard-user')

@section('title', 'Data Hasil Deteksi')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Hasil Deteksi Risiko Stroke</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary mb-2 mb-md-0">Daftar Deteksi Pengguna</h6>
            <form action="{{ route('admin.hasil-prediksi') }}" method="GET" class="mt-2 mt-md-0">
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
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Nama Akun</th>
                            <th class="text-center" style="width: 100px;">Usia</th>
                            <th class="text-center" style="width: 200px;">Hasil Deteksi</th>
                            <th class="text-center" style="width: 150px;">Tanggal Deteksi</th>
                            <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->name ?? '-' }}</td>
                            <td class="text-center">{{ is_numeric($item->age) ? $item->age . ' tahun' : $item->age }}</td>
                            <td class="text-center">
                                @php
                                    $predictionText = strtolower($item->prediction ?? '');
                                @endphp
                                @if ($predictionText === 'anda beresiko terkena stroke')
                                    <span class="badge badge-pill badge-danger py-2 px-3">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> {{ $item->prediction }}
                                    </span>
                                @elseif ($predictionText === 'anda tidak beresiko')
                                    <span class="badge badge-pill badge-success py-2 px-3">
                                        <i class="fas fa-check-circle mr-1"></i> {{ $item->prediction }}
                                    </span>
                                @else
                                    <span class="badge badge-pill badge-secondary py-2 px-3">
                                        <i class="fas fa-question-circle mr-1"></i> {{ $item->prediction ?? 'Tidak ada data' }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.hasil-prediksi.show', ['id' => $item->_id]) }}" class="btn btn-info btn-sm btn-circle" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Tidak ada data deteksi yang ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $data->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<style>
    .table {
        font-size: 0.9rem;
    }
    .badge {
        font-size: 0.85rem;
        font-weight: 500;
    }
    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .thead-light th {
        background-color: #f8f9fc;
        font-weight: 600;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>

@endsection