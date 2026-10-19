<div>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <i class="fas fa-users"></i>
                            {{ $title }}
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fas fa-home mr-1"></i>Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <button wire:click="create" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#createModal">
                                <i class="fas fa-plus mr-1"></i> Tambah Data
                            </button>
                        </div>
                        <!-- Default dropstart button -->
                        <div class="btn-group dropleft">
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-print"></i>
                                Export To
                            </button>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item text-danger"
                                    href="{{ route('superadmin.user.export.pdf', ['search' => $search]) }}"><i
                                        class="fas fa-file-pdf mr-1"></i>
                                    PDF</a>
                                <a class="dropdown-item text-success"
                                    href="{{ route('superadmin.user.export.excel', ['search' => $search]) }}"><i
                                        class="fas fa-file-excel mr-1"></i> Excel</a>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="mb-3 d-flex justify-content-between">
                        <div class="col-2">
                            <select wire:model.live="paginate" class="form-control">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <input wire:model.live="search" type="text" class="form-control" placeholder="Search..">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>
                                        <i class="fas fa-cog"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->email }}</td>
                                        @if ($item->role == 'Super Admin')
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ $item->role }}
                                                </span>
                                            </td>
                                        @else
                                            <td><span class="badge badge-secondary">{{ $item->role }}</span>    </td>
                                        @endif
                                        <td>
                                            <div class="btn-group">
                                                <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-warning mr-1"
                                                    data-toggle="modal" data-target="#editModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click="confirm({{ $item->id }})" class="btn btn-sm btn-danger"
                                                    data-toggle="modal" data-target="#deleteModal">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $user->links() }}
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->

        {{-- Create Modal --}}
        @include('components.superadmin.user.create')

        {{-- Close Create modal --}}
        @script
            <script>
                $wire.on('close-create-modal', () => {
                    $('#createModal').modal('hide');
                    Swal.fire({
                        title: "Sukses!",
                        text: "Data berhasil ditambahkan!",
                        icon: "success"
                    });
                });
            </script>
        @endscript

        {{-- Create edit --}}
        @include('components.superadmin.user.edit')
        @script
            <script>
                $wire.on('close-edit-modal', () => {
                    $('#editModal').modal('hide');
                    Swal.fire({
                        title: "Sukses!",
                        text: "Data berhasil diubah!",
                        icon: "success"
                    });
                });
            </script>
        @endscript

        {{-- delete modal --}}
        @include('components.superadmin.user.delete')
        @script
            <script>
                $wire.on('close-delete-modal', () => {
                    $('#deleteModal').modal('hide');
                    Swal.fire({
                        title: "Sukses!",
                        text: "Data berhasil dihapus!",
                        icon: "success"
                    });
                });
            </script>
        @endscript
    </div>
</div>
