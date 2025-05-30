@extends('user.dashboard-user')

@section('title', 'Detail Konsultasi')

@section('content')
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Detail Konsultasi</h1>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Konsultasi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> {{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}</p>
                            <p><strong>Identitas:</strong> {{ $konsultasi->identitas ?? '-' }}</p>
                            <p><strong>Keluhan:</strong> {{ $konsultasi->keluhan ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Jawaban:</strong> {{ $konsultasi->jawaban ?? 'Sedang menunggu jawaban' }}</p>
                            <p><strong>Nama Pemberi Jawaban:</strong> {{ $konsultasi->nama_pemberi_jawaban ?? '-' }}</p>
                            <p><strong>Dibuat Pada:</strong> {{ $konsultasi->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge {{ $konsultasi->jawaban ? 'badge-secondary' : 'badge-primary' }}">
                                    {{ $konsultasi->jawaban ? 'Selesai' : 'Pending' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        @if (!$konsultasi->jawaban)
                            <form action="{{ route('konsultasi.destroy', $konsultasi->_id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('konsultasi.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

0 // Timer hanya untuk notifikasi sukses