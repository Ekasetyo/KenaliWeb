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
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" name="judul" value="{{ old('judul') }}"
                               placeholder="Masukkan judul artikel (minimal 5 karakter)" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi:</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="5"
                                  placeholder="Masukkan deskripsi artikel (minimal 100 karakter)" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="penulis">Penulis:</label>
                        <input type="text" class="form-control @error('penulis') is-invalid @enderror" 
                               id="penulis" name="penulis" value="{{ old('penulis') }}"
                               placeholder="Masukkan nama penulis (minimal 3 karakter)" required>
                        @error('penulis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sumber">Sumber:</label>
                        <input type="url" class="form-control @error('sumber') is-invalid @enderror" 
                               id="sumber" name="sumber" value="{{ old('sumber') }}"
                               placeholder="Masukkan URL sumber (contoh: https://example.com)" required>
                        @error('sumber')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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