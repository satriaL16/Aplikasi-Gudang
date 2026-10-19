<?php

namespace App\Livewire\Superadmin\Kategori;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $paginate = '10';

    public $search = '';

    public $nama_kategori;

    public $kategori_id;

    public function render()
    {
        $data = [
            'title' => 'Data Kategori',
            'kategori' => Kategori::where('nama_kategori', 'like', '%'.$this->search.'%')->orderBy('nama_kategori', 'asc')->paginate($this->paginate),
        ];

        return view('components.superadmin.kategori.index', $data);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset([
            'nama_kategori',
        ]);
    }

    public function store()
    {
        $this->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori|max:255',
        ], [
            'nama_kategori.required' => 'Nama Kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama Kategori sudah digunakan.',
        ]);

        $kategori = new Kategori;
        $kategori->nama_kategori = $this->nama_kategori;
        $kategori->save();

        $this->dispatch('close-create-modal');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $kategori = Kategori::findOrFail($id);
        $this->nama_kategori = $kategori->nama_kategori;
        $this->kategori_id = $kategori->id;
    }

    public function update($id)
    {
        $kategori = Kategori::findOrFail($id);
        $this->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori,'.$kategori->id.'|max:255',
        ], [
            'nama_kategori.required' => 'Nama Kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama Kategori sudah digunakan.',
        ]);

        $kategori->nama_kategori = $this->nama_kategori;
        $kategori->save();

        $this->dispatch('close-edit-modal');
    }

    public function confirm($id)
    {
        $kategori = Kategori::findOrFail($id);
        $this->nama_kategori = $kategori->nama_kategori;
        $this->kategori_id = $kategori->id;
    }

    public function destroy(int $id): void
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->barangs()->exists()) {
            $this->dispatch('category-delete-blocked');

            return;
        }

        $kategori->delete();
        $this->dispatch('close-delete-modal');
    }
}
