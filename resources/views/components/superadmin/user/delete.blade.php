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
                        Nama
                    </div>
                    <div class="col-8">
                        : {{ $nama }}
                    </div>
                </div>
                {{-- email --}}
                <div class="row">
                    <div class="col-4">
                        Email
                    </div>
                    <div class="col-8">
                        : {{ $email }}
                    </div>
                </div>
                {{-- role --}}
                <div class="row">
                    <div class="col-4">
                        Role
                    </div>
                    <div class="col-8">
                        :
                        @if ($role === 'Super Admin')
                            <span class="badge badge-info">
                                {{ $role }}
                            </span>
                        @else
                            <span class="badge badge-secondary">{{ $role }}</span>
                        @endif  
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times mr-1"></i>Batal</button>
                <button wire:click="destroy({{ $user_id }})" type="button" class="btn btn-danger"><i
                        class="fas fa-trash mr-1"></i>Hapus</button>
            </div>
        </div>
    </div>
</div>
