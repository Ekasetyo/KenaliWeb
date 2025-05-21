@extends('user.dashboard-user')

@section('title', 'Konsultasi')

@section('content')
<div id="content">
    <div class="container-fluid">

        <!-- Page Heading dan Tombol Tambah Konsultasi -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0 text-gray-800">Konsultasi</h1>
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahKonsultasiModal">
                <i class="fas fa-plus"></i> Tambah Konsultasi
            </button>
        </div>

        <!-- Tabel Konsultasi (Tanpa Database, Data Statis/Session) -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Konsultasi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Pesan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody id="konsultasiBody">
                            <!-- Data konsultasi akan muncul di sini -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Konsultasi -->
        <div class="modal fade" id="tambahKonsultasiModal" tabindex="-1" aria-labelledby="tambahKonsultasiModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formKonsultasi" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahKonsultasiModalLabel">Tambah Konsultasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama:</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                            </div>
                            <div class="form-group">
                                <label for="pesan">Pesan Konsultasi:</label>
                                <textarea class="form-control" id="pesan" name="pesan" rows="4" placeholder="Tulis pesan konsultasi Anda" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Script untuk simpan data konsultasi ke sessionStorage (tanpa database) -->
<script>
    // Ambil data dari sessionStorage atau buat array kosong
    let konsultasiList = JSON.parse(sessionStorage.getItem('konsultasiList') || '[]');

    // Fungsi render data ke tabel
    function renderKonsultasi() {
        const tbody = document.getElementById('konsultasiBody');
        tbody.innerHTML = '';
        if (konsultasiList.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">Belum ada konsultasi.</td></tr>`;
        } else {
            konsultasiList.forEach(function(item, idx) {
                tbody.innerHTML += `
                    <tr>
                        <td>${idx + 1}</td>
                        <td>${item.nama}</td>
                        <td>${item.email}</td>
                        <td>${item.pesan}</td>
                        <td><span class="badge badge-secondary">Terkirim</span></td>
                        <td>${item.tanggal}</td>
                    </tr>
                `;
            });
        }
    }

    // Saat form disubmit
    document.addEventListener('DOMContentLoaded', function() {
        renderKonsultasi();

        document.getElementById('formKonsultasi').onsubmit = function(e) {
            e.preventDefault();
            const nama = document.getElementById('nama').value;
            const email = document.getElementById('email').value;
            const pesan = document.getElementById('pesan').value;
            const tanggal = new Date().toLocaleString('id-ID');

            konsultasiList.push({ nama, email, pesan, tanggal });
            sessionStorage.setItem('konsultasiList', JSON.stringify(konsultasiList));
            renderKonsultasi();

            // Reset form dan tutup modal
            this.reset();
            $('#tambahKonsultasiModal').modal('hide');
        };
    });
</script>
@endsection