@extends('admin.dashboard-admin')

@section('title', 'Konsultasi')

@section('content')
    <div id="content">
        <div class="container-fluid">
            <!-- Header dengan ikon -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-comments mr-2"></i>Daftar Konsultasi Pasien
                </h1>
            </div>

            <!-- Filter Section -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body py-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label for="status-filter" class="font-weight-600 text-primary">Status Konsultasi</label>
                                <select class="form-control border-primary" id="status-filter" name="status">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Jawaban</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label for="date-filter" class="font-weight-600 text-primary">Filter Tanggal</label>
                                <input type="date" class="form-control border-primary" id="date-filter" name="date"
                                    value="{{ request('date') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label for="search" class="font-weight-600 text-primary">Cari Konsultasi</label>
                                <div class="input-group">
                                    <input type="text" class="form-control border-primary" id="search" name="search" 
                                        placeholder="Cari nama" value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="applyFilters()">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Konsultasi -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-2"></i>Daftar Konsultasi
                    </h6>
                </div>
                <div class="card-body px-0 pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover" id="consultationTable" width="100%" cellspacing="0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0" style="width: 5%;">No</th>
                                    <th class="border-0" style="width: 15%;">Nama Pasien</th>
                                    <th class="border-0" style="width: 15%;">Email</th>
                                    <th class="border-0" style="width: 15%;">Identitas</th>
                                    <th class="border-0" style="width: 20%;">Keluhan</th>
                                    <th class="border-0" style="width: 10%;">Status</th>
                                    <th class="border-0" style="width: 10%;">Tanggal</th>
                                    <th class="border-0" style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftar_konsultasi as $index => $konsultasi)
                                    <tr class="border-bottom">
                                        <td class="align-middle">{{ $index + 1 }}</td>
                                        <td class="align-middle text-ellipsis">
                                            <i class="fas fa-user-circle mr-2 text-primary"></i>
                                            {{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}
                                        </td>
                                        <td class="align-middle text-ellipsis">
                                            <i class="fas fa-envelope mr-2 text-muted"></i>
                                            {{ $konsultasi->pengguna->email ?? '-' }}
                                        </td>
                                        <td class="align-middle text-ellipsis">{{ $konsultasi->identitas ?? '-' }}</td>
                                        <td class="align-middle text-ellipsis">{{ $konsultasi->keluhan ?? '-' }}</td>
                                        <td class="align-middle">
                                            <span class="badge badge-pill {{ $konsultasi->jawaban ? 'badge-success' : 'badge-warning' }}">
                                                {{ $konsultasi->jawaban ? 'Selesai' : 'Menunggu' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-ellipsis">
                                            <i class="far fa-calendar-alt mr-2 text-muted"></i>
                                            {{ $konsultasi->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('admin.konsultasi.show', $konsultasi->_id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill">
                                                <i class="fas fa-comment-dots mr-1"></i> Buka
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">Belum ada konsultasi</h5>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Chat -->
        <div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-comments mr-2"></i>Chat Konsultasi
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="chat-header mb-4 p-3 bg-light rounded">
                            <h6 class="font-weight-bold mb-1">
                                <i class="fas fa-user mr-2"></i>
                                <span id="customer-name">-</span>
                            </h6>
                            <p class="mb-1 text-muted small">
                                <i class="fas fa-envelope mr-2"></i>
                                <span id="customer-email">-</span>
                            </p>
                            <p class="mb-0 text-muted small">
                                <i class="fas fa-id-card mr-2"></i>
                                <span id="consultation-topic">-</span>
                            </p>
                        </div>
                        
                        <div id="chat-container" class="chat-messages mb-4">
                            <div id="chat-messages" class="p-3"></div>
                        </div>
                        
                        <form id="reply-form" action="{{ route('admin.konsultasi.reply') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="consultation-id">
                            
                            <div class="form-group mb-3">
                                <label class="font-weight-600 text-primary">Balasan Anda</label>
                                <textarea class="form-control border-primary @error('jawaban') is-invalid @enderror" 
                                    id="message-input" name="jawaban" rows="3"
                                    placeholder="Tulis jawaban Anda di sini..." required></textarea>
                                @error('jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="font-weight-600 text-primary">Nama Anda</label>
                                <input type="text" class="form-control border-primary @error('nama_pemberi_jawaban') is-invalid @enderror"
                                    id="admin-name" name="nama_pemberi_jawaban" placeholder="Masukkan nama Anda" required>
                                @error('nama_pemberi_jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="text-right">
                                <button type="button" class="btn btn-outline-secondary mr-2 rounded-pill" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i> Tutup
                                </button>
                                <button type="button" class="btn btn-primary rounded-pill" onclick="confirmReply()">
                                    <i class="fas fa-paper-plane mr-1"></i> Kirim Balasan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom Styles */
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: none;
        }
        
        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }
        
        .table th {
            font-weight: 600;
            color: #4e73df;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .badge-pill {
            padding: 0.35em 0.65em;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .chat-messages {
            height: 300px;
            overflow-y: auto;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e3e6f0;
        }
        
        .message {
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 8px;
            max-width: 80%;
        }
        
        .user-message {
            background-color: #e3f2fd;
            margin-right: auto;
        }
        
        .admin-message {
            background-color: #f1f1f1;
            margin-left: auto;
        }
        
        .empty-state {
            opacity: 0.6;
        }
        
        .text-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
        
        .btn-rounded {
            border-radius: 50px;
        }
        
        .border-primary {
            border-color: #4e73df !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function applyFilters() {
            const status = document.getElementById('status-filter').value;
            const date = document.getElementById('date-filter').value;
            const search = document.getElementById('search').value;

            const url = new URL(window.location.href);
            url.searchParams.set('status', status);
            if (date) url.searchParams.set('date', date);
            else url.searchParams.delete('date');
            if (search) url.searchParams.set('search', search);
            else url.searchParams.delete('search');

            window.location.href = url.toString();
        }

        function confirmReply() {
            Swal.fire({
                title: 'Kirim Balasan?',
                text: 'Pastikan jawaban Anda sudah benar sebelum mengirim.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Kirim Sekarang',
                cancelButtonText: 'Periksa Lagi'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reply-form').submit();
                }
            });
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000,
                background: '#f8f9fa',
                backdrop: `
                    rgba(78,115,223,0.4)
                    url("/images/nyan-cat.gif")
                    center top
                    no-repeat
                `
            });
            window.history.replaceState({}, document.title, window.location.pathname + window.location.search);
        @endif
        
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#e74a3b'
            });
            window.history.replaceState({}, document.title, window.location.pathname + window.location.search);
        @endif
    </script>
@endpush