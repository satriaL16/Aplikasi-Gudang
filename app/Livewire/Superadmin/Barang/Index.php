<?php

namespace App\Livewire\Superadmin\Barang;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public int $paginate = 10;

    public string $search = '';

    public string $nama_kategori = '';

    public string $nama_barang = '';

    public string $kategori_id = '';

    public string $harga = '';

    public string $stok = '';

    public int $barang_id = 0;

    public function render(): View
    {
        return view($this->barangView(), $this->viewData());
    }

    protected function barangView(): string
    {
        return 'components.superadmin.barang.index';
    }

    /**
     * @return array{
     *     title: string,
     *     barang: LengthAwarePaginator,
     *     kategoriList: Collection<int, Kategori>
     * }
     */
    protected function viewData(): array
    {
        $search = trim($this->search);

        return [
            'title' => 'Data Barang',
            'barang' => Barang::query()
                ->with('kategori')
                ->when($search !== '', function (Builder $query) use ($search): void {
                    $query->where(function (Builder $query) use ($search): void {
                        $query->where('nama_barang', 'like', "%{$search}%")
                            ->orWhereHas('kategori', function (Builder $query) use ($search): void {
                                $query->where('nama_kategori', 'like', "%{$search}%");
                            });
                    });
                })
                ->orderBy('nama_barang')
                ->paginate(min(max($this->paginate, 1), 100)),
            'kategoriList' => Kategori::query()->orderBy('nama_kategori')->get(),
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPaginate(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetValidation();
        $this->reset([
            'nama_kategori',
            'nama_barang',
            'kategori_id',
            'harga',
            'stok',
            'barang_id',
        ]);
    }

    public function store(): void
    {
        $validated = $this->validate($this->validationRules(), $this->validationMessages());

        Barang::query()->create($validated);

        $this->resetPage();
        $this->dispatch('close-create-modal');
    }

    public function edit(int $id): void
    {
        $this->resetValidation();
        $barang = Barang::query()->with('kategori')->findOrFail($id);
        $this->nama_kategori = $barang->kategori->nama_kategori;
        $this->nama_barang = $barang->nama_barang;
        $this->kategori_id = (string) $barang->kategori_id;
        $this->harga = $barang->harga;
        $this->stok = (string) $barang->stok;
        $this->barang_id = $barang->id;
    }

    public function update(int $id): void
    {
        $barang = Barang::query()->findOrFail($id);
        $validated = $this->validate($this->validationRules(), $this->validationMessages());

        $barang->update($validated);

        $this->resetPage();
        $this->dispatch('close-edit-modal');
    }

    public function confirm(int $id): void
    {
        $barang = Barang::query()->with('kategori')->findOrFail($id);
        $this->nama_kategori = $barang->kategori->nama_kategori;
        $this->nama_barang = $barang->nama_barang;
        $this->kategori_id = (string) $barang->kategori_id;
        $this->harga = $barang->harga;
        $this->stok = (string) $barang->stok;
        $this->barang_id = $barang->id;
    }

    public function destroy(int $id): void
    {
        Barang::query()->findOrFail($id)->delete();

        $this->resetPage();
        $this->dispatch('close-delete-modal');
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function validationRules(): array
    {
        return [
            'nama_barang' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'integer', 'exists:kategoris,id'],
            'harga' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:9999999999.99'],
            'stok' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function validationMessages(): array
    {
        return [
            'nama_barang.required' => 'Nama Barang wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.decimal' => 'Harga maksimal memiliki 2 angka di belakang koma.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'harga.max' => 'Harga terlalu besar.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa bilangan bulat.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
        ];
    }
}
