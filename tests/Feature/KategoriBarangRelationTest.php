<?php

namespace Tests\Feature;

use App\Livewire\Superadmin\Kategori\Index;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class KategoriBarangRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_cannot_be_deleted_while_it_has_barang(): void
    {
        $kategori = new Kategori;
        $kategori->nama_kategori = 'Elektronik';
        $kategori->save();

        $barang = Barang::query()->create([
            'kategori_id' => $kategori->id,
            'nama_barang' => 'Laptop',
            'harga' => '12500000.00',
            'stok' => 8,
        ]);

        Livewire::test(Index::class)
            ->call('destroy', $kategori->id)
            ->assertDispatched('category-delete-blocked');

        $this->assertModelExists($kategori);
        $this->assertModelExists($barang);
    }
}
