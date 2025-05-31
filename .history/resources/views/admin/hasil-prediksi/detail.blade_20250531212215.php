@extends('admin.dashboard-admin')

@section('title', 'Detail Hasil Deteksi')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Hasil Deteksi Risiko Stroke</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Informasi Deteksi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-left-primary shadow">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user mr-2"></i> Informasi Pribadi</h5>
                            <div class="mb-2"><strong>Nama:</strong> {{ $data->name ?? '-' }}</div>
                            <div class="mb-2"><strong>Usia:</strong> {{ is_numeric($data->age) ? $data->age . ' tahun' : $data->age }}</div>
                            <div class="mb-2"><strong>Jenis Kelamin:</strong> {{ $data->sex == 1 ? 'Laki-laki' : ($data->sex == 0 ? 'Perempuan' : '-') }}</div>
                            <div class="mb-2"><strong>Status Pernikahan:</strong> {{ $data->ever_married == 1 ? 'Pernah Menikah' : ($data->ever_married == 0 ? 'Belum Menikah' : '-') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-left-success shadow">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-heartbeat mr-2"></i> Kesehatan</h5>
                            <div class="mb-2"><strong>Hipertensi:</strong> {{ $data->hypertension == 1 ? 'Ya' : ($data->hypertension == 0 ? 'Tidak' : '-') }}</div>
                            <div class="mb-2"><strong>Penyakit Jantung:</strong> {{ $data->heart_disease == 1 ? 'Ya' : ($data->heart_disease == 0 ? 'Tidak' : '-') }}</div>
                            <div class="mb-2"><strong>Kadar Glukosa Rata-rata:</strong> {{ $data->avg_glucose_level ?? '-' }} mg/dL</div>
                            <div class="mb-2"><strong>BMI:</strong> {{ $data->bmi ?? '-' }}</div>
                            <div class="mb-2"><strong>Status Merokok:</strong> 
                                {{ $data->smoking_status == 1 ? 'Merokok' : ($data->smoking_status == 0 ? 'Tidak Merokok' : ($data->smoking_status == 2 ? 'Pernah Merokok' : '-')) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-left-info shadow">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-briefcase mr-2"></i> Pekerjaan & Tempat Tinggal</h5>
                            <div class="mb-2"><strong>Tipe Pekerjaan:</strong> 
                                {{ $data->work_type == 0 ? 'Pernah Bekerja' : ($data->work_type == 1 ? 'Pekerjaan Swasta' : ($data->work_type == 2 ? 'PNS' : ($data->work_type == 3 ? 'Wirausaha' : '-'))) }}
                            </div>
                            <div class="mb-2"><strong>Tipe Tempat Tinggal:</strong> {{ $data->Residence_type == 1 ? 'Perkotaan' : ($data->Residence_type == 0 ? 'Pedesaan' : '-') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-left-warning shadow">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-clipboard-check mr-2"></i> Hasil Deteksi</h5>
                            <div class="mb-2"><strong>Prediksi:</strong> 
                                <span class="badge {{ str_contains(strtolower($data->prediction ?? ''), 'beresiko') ? 'badge-danger' : 'badge-success' }}">
                                    {{ $data->prediction ?? 'Tidak ada data' }}
                                </span>
                            </div>
                            <div class="mb-2"><strong>Tanggal Deteksi:</strong> {{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i') : '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="{{ route('admin.hasil-prediksi') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>

<style>
    
</style>
@endsection