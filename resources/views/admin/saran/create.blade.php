<div class="modal fade" id="formTambahSaran" tabindex="-1" role="dialog" aria-labelledby="formTambahUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formTambahSaran">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/dashboard/data-master') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Pemberi</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Masukkan nama" required>
                    </div>
                    <div class="form-group">
                        <label for="saran">Saran</label>
                        <input type="address" class="form-control" id="email" name="email"
                            placeholder="Masukkan saran" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                </form>
            </div>
        </div>
    </div>
</div>
