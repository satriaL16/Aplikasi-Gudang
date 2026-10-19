<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-plus mr-1"></i> Tambah {{ $title }}
                </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label for="nama" class="form-label">Nama :</label>
                    <span class="text-danger">*</span>
                    <input wire:model="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                        placeholder="Masukkan Nama">
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row mt-2">
                    <label for="email" class="form-label">Email :</label>
                    <span class="text-danger">*</span>
                    <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Masukkan Email">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>
                <div class="row mt-2">
                    <label for="role" class="form-label">Role :</label>
                    <span class="text-danger">*</span>
                    <select id="role" wire:model="role" class="form-control @error('role') is-invalid @enderror">
                        <option selected>--Pilih Role--</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Admin">Admin</option>
                    </select>
                    @error('role')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row mt-2">
                    <label for="password" class="form-label">Password :</label>
                    <span class="text-danger">*</span>
                    <input wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Masukkan Password">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row mt-2">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password :</label>
                    <span class="text-danger">*</span>
                    <input wire:model="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Masukkan Konfirmasi Password">
                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times mr-1"></i>Batal</button>
                <button wire:click="store" type="button" class="btn btn-primary"><i
                        class="fas fa-save mr-1"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>
