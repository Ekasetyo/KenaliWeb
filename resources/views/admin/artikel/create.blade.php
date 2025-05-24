<div class="modal fade" id="formTambahArtikel" tabindex="-1" role="dialog" aria-labelledby="formTambahArtikelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formTambahArtikel">Tambah Data Artikel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.artikel.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="judul">Judul:</label>
                        <input type="text" class="form-control" id="judul" name="judul"
                            placeholder="Masukkan judul artikel" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi:</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"
                            placeholder="Masukkan deskripsi artikel" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="penulis">Penulis:</label>
                        <input type="text" class="form-control" id="penulis" name="penulis"
                            placeholder="Masukkan nama penulis" required>
                    </div>
                    <div class="form-group">
                        <label for="sumber">Sumber:</label>
                        <input type="url" class="form-control" id="sumber" name="sumber"
                            placeholder="Masukkan URL sumber (contoh: https://example.com)" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>