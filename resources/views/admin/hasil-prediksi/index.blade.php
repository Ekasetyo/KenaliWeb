@extends('admin.dashboard-admin')

@section('title', 'Data Hasil Deteksi')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Data Hasil Deteksi Risiko Stroke para User</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Deteksi Para User</h6>
            <form action="{{ route('admin.hasil-prediksi') }}" method="GET" class="form-inline">
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
                            <th>Nama Akun</th>
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
                                @php
                                    $predictionText = strtolower($item->prediction ?? '');
                                @endphp
                                @if ($predictionText === 'anda beresiko terkena stroke')
                                    <span class="badge badge-danger">
                                        {{ $item->prediction }}
                                    </span>
                                @elseif ($predictionText === 'anda tidak beresiko')
                                    <span class="badge badge-success">
                                        {{ $item->prediction }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        {{ $item->prediction ?? 'Tidak ada data' }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <a href="{{ route('admin.hasil-prediksi.show', ['id' => $item->_id]) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
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

