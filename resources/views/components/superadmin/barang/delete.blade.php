<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteBarangModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBarangModalLabel">
                    <i class="fas fa-trash mr-1"></i> Hapus {{ $title }}
                </h5>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-4">Nama Kategori</div>
                    <div class="col-8">: {{ $nama_kategori }}</div>
                </div>
                <div class="row">
                    <div class="col-4">Nama Barang</div>
                    <div class="col-8">: {{ $nama_barang }}</div>
                </div>
                <div class="row">
                    <div class="col-4">Harga</div>
                    <div class="col-8">: Rp {{ $harga }}</div>
                </div>
                <div class="row">
                    <div class="col-4">Stok</div>
                    <div class="col-8">: {{ $stok }}</div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Batal
                </button>
                <button wire:click="destroy({{ $barang_id }})" type="button" class="btn btn-danger">
                    <i class="fas fa-trash mr-1"></i>Hapus
                </button>
            </div>
        </div>
    </div>
</div>
