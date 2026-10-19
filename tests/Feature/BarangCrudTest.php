<?php

namespace Tests\Feature;

use App\Livewire\Superadmin\Barang\Index;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BarangCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_barang_is_created_with_its_category(): void
    {
        $kategori = $this->createKategori('Elektronik');

        Livewire::test(Index::class)
            ->set('kategori_id', (string) $kategori->id)
            ->set('nama_barang', 'Laptop')
            ->set('harga', '12500000.50')
            ->set('stok', '8')
            ->call('store')
            ->assertHasNoErrors()
            ->assertDispatched('close-create-modal');

        $this->assertDatabaseHas('barangs', [
            'kategori_id' => $kategori->id,
            'nama_barang' => 'Laptop',
            'harga' => '12500000.50',
            'stok' => 8,
        ]);
    }

    public function test_barang_is_updated(): void
    {
        $kategori = $this->createKategori('Elektronik');
        $barang = $this->createBarang($kategori, 'Laptop', '12500000.00', 8);

        Livewire::test(Index::class)
            ->call('edit', $barang->id)
            ->set('nama_barang', 'Laptop Pro')
            ->set('harga', '15000000.00')
            ->set('stok', '5')
            ->call('update', $barang->id)
            ->assertHasNoErrors()
            ->assertDispatched('close-edit-modal');

        $this->assertDatabaseHas('barangs', [
            'id' => $barang->id,
            'kategori_id' => $kategori->id,
            'nama_barang' => 'Laptop Pro',
            'harga' => '15000000.00',
            'stok' => 5,
        ]);
    }

    public function test_barang_is_deleted(): void
    {
        $kategori = $this->createKategori('Elektronik');
        $barang = $this->createBarang($kategori, 'Laptop', '12500000.00', 8);

        Livewire::test(Index::class)
            ->call('confirm', $barang->id)
            ->call('destroy', $barang->id)
            ->assertDispatched('close-delete-modal');

        $this->assertDatabaseMissing('barangs', ['id' => $barang->id]);
    }

    public function test_invalid_barang_data_is_rejected(): void
    {
        $this->createKategori('Elektronik');

        Livewire::test(Index::class)
            ->set('kategori_id', '999')
            ->set('nama_barang', '')
            ->set('harga', '100.123')
            ->set('stok', '-1')
            ->call('store')
            ->assertHasErrors([
                'kategori_id' => 'exists',
                'nama_barang' => 'required',
                'harga' => 'decimal',
                'stok' => 'min',
            ]);

        $this->assertDatabaseCount('barangs', 0);
    }

    public function test_barang_search_matches_barang_and_category_names(): void
    {
        $elektronik = $this->createKategori('Elektronik');
        $makanan = $this->createKategori('Makanan');
        $this->createBarang($elektronik, 'Laptop', '12500000.00', 8);
        $this->createBarang($makanan, 'Kopi', '25000.00', 20);

        Livewire::test(Index::class)
            ->set('search', 'Elektronik')
            ->assertSee('Laptop')
            ->assertDontSee('Kopi')
            ->set('search', 'Kopi')
            ->assertSee('Kopi')
            ->assertDontSee('Laptop');
    }

    private function createKategori(string $namaKategori): Kategori
    {
        $kategori = new Kategori;
        $kategori->nama_kategori = $namaKategori;
        $kategori->save();

        return $kategori;
    }

    private function createBarang(Kategori $kategori, string $namaBarang, string $harga, int $stok): Barang
    {
        return Barang::query()->create([
            'kategori_id' => $kategori->id,
            'nama_barang' => $namaBarang,
            'harga' => $harga,
            'stok' => $stok,
        ]);
    }
}
