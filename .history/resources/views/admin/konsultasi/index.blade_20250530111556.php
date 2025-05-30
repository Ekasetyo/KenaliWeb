@extends('admin.dashboard-admin')

@section('title', 'Konsultasi')

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Daftar Konsultasi Pasien</h1>

            <!-- Filter Section -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status-filter">Filter Status</label>
                        <select class="form-control" id="status-filter" name="status">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date-filter">Filter Tanggal</label>
                        <input type="date" class="form-control" id="date-filter" name="date" value="{{ request('date') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="search">Cari Konsultasi</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Cari..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="applyFilters()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consultation List -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">Daftar Konsultasi</h6>
    <button class="btn btn-primary btn-sm" onclick="refreshData()">
        <i class="fas fa-sync-alt"></i> Refresh
    </button>
</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="consultationTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Identitas</th>
                                    <th>Keluhan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftar_konsultasi as $index => $konsultasi)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $konsultasi->pengguna->name ?? 'Tidak diketahui' }}</td>
                                        <td>{{ $konsultasi->pengguna->email ?? '-' }}</td>
                                        <td>{{ $konsultasi->identitas ?? '-' }}</td>
                                        <td>{{ $konsultasi->keluhan ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $konsultasi->jawaban ? 'badge-secondary' : 'badge-primary' }}">
                                                {{ $konsultasi->jawaban ? 'Selesai' : 'Aktif' }}
                                            </span>
                                        </td>
                                        <td>{{ $konsultasi->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.konsultasi.show', $konsultasi->_id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-comments"></i> Buka Chat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada konsultasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Modal -->
        <div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chat Konsultasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="chat-header mb-3">
                            <h6>Pasien: <span id="customer-name"></span></h6>
                            <p>Email: <span id="customer-email"></span> | Identitas: <span id="consultation-topic"></span></p>
                        </div>
                        
                        <!-- Chat Messages Container -->
                        <div id="chat-container" style="height: 300px; overflow-y: auto; margin-bottom: 20px; padding: 15px; border: 1px solid #e3e6f0; border-radius: 5px; background-color: #fafafa;">
                            <div id="chat-messages"></div>
                        </div>
                        
                        <!-- Reply Form -->
                        <form id="reply-form" action="{{ route('admin.konsultasi.reply') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="consultation-id">
                            <div class="form-group">
                                <textarea class="form-control @error('jawaban') is-invalid @enderror" id="message-input" name="jawaban" rows="3" placeholder="Ketik balasan Anda..." required></textarea>
                                @error('jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control @error('nama_pemberi_jawaban') is-invalid @enderror" id="admin-name" name="nama_pemberi_jawaban" placeholder="Nama Anda" required>
                                @error('nama_pemberi_jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-paper-plane"></i> Kirim
                                </button>
                            </div>
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

        function refreshData() {
            // Tambahkan parameter untuk memaksa refresh tanpa cache
            const url = '{{ route("admin.konsultasi.index") }}' + '?refresh=' + new Date().getTime();
            window.location.href = url; // Redirect dengan timestamp untuk menghindari cache
        }

        document.querySelectorAll('.view-chat').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const row = this.closest('tr');
                const customerName = row.cells[1].innerText;
                const customerEmail = row.cells[2].innerText;
                const topic = row.cells[3].innerText;

                document.getElementById('customer-name').innerText = customerName;
                document.getElementById('customer-email').innerText = customerEmail;
                document.getElementById('consultation-topic').innerText = topic;
                document.getElementById('consultation-id').value = id;

                const chatMessages = document.getElementById('chat-messages');
                chatMessages.innerHTML = `
                    <div class="message user-message mb-3">
                        <div class="message-header">
                            <strong>${customerName}</strong>
                            <small class="text-muted">${row.cells[5].innerText}</small>
                        </div>
                        <div class="message-body">
                            ${row.cells[4].innerText}
                        </div>
                    </div>
                `;

                $('#chatModal').modal('show');
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            });
            window.history.replaceState({}, document.title, window.location.pathname + window.location.search);
        @endif
    </script>
@endpush