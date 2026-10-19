<!-- Modal -->
<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-trash mr-1"></i> Hapus {{ $title }}
                </h5>
            </div>

            <div class="modal-body">
                {{-- nama --}}
                <div class="row">
                    <div class="col-4">
                        Nama Kategori
                    </div>
                    <div class="col-8">
                        : {{ $nama_kategori }}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times mr-1"></i>Batal</button>
                <button wire:click="destroy({{ $kategori_id }})" type="button" class="btn btn-danger"><i
                        class="fas fa-trash mr-1"></i>Hapus</button>
            </div>
        </div>
    </div>
</div>
