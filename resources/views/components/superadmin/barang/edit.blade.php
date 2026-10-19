<div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editBarangModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangModalLabel">
                    <i class="fas fa-edit mr-1"></i> Edit {{ $title }}
                </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label for="edit-kategori_id" class="form-label">Nama Kategori :</label>
                    <span class="text-danger">*</span>
                    <select id="edit-kategori_id" wire:model="kategori_id"
                        class="form-control @error('kategori_id') is-invalid @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoriList as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row mt-2">
                    <label for="edit-nama_barang" class="form-label">Nama Barang :</label>
                    <span class="text-danger">*</span>
                    <input id="edit-nama_barang" wire:model="nama_barang" type="text"
                        class="form-control @error('nama_barang') is-invalid @enderror"
                        placeholder="Masukkan nama barang">
                    @error('nama_barang')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row mt-2">
                    <label for="edit-harga" class="form-label">Harga :</label>
                    <span class="text-danger">*</span>
                    <input id="edit-harga" wire:model="harga" type="number" min="0" step="0.01"
                        class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan harga">
                    @error('harga')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row mt-2">
                    <label for="edit-stok" class="form-label">Stok :</label>
                    <span class="text-danger">*</span>
                    <input id="edit-stok" wire:model="stok" type="number" min="0" step="1"
                        class="form-control @error('stok') is-invalid @enderror" placeholder="Masukkan stok">
                    @error('stok')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Batal
                </button>
                <button wire:click="update({{ $barang_id }})" type="button" class="btn btn-warning">
                    <i class="fas fa-save mr-1"></i>Update
                </button>
            </div>
        </div>
    </div>
</div>
