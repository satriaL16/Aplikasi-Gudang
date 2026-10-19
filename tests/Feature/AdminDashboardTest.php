<?php

namespace Tests\Feature;

use App\Livewire\Admin\Barang\Index as AdminBarangIndex;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_is_redirected_to_admin_dashboard_and_sees_only_admin_navigation(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertRedirectToRoute('admin.dashboard');

        $this->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Dashboard Admin')
            ->assertSee('Kelola Barang')
            ->assertSee(route('admin.barang.index'))
            ->assertDontSee(route('superadmin.user.index'));
    }

    public function test_admin_dashboard_displays_total_barang_count(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $kategori = $this->createKategori('Elektronik');
        $this->createBarang($kategori, 'Laptop');
        $this->createBarang($kategori, 'Monitor');

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Total Data Barang')
            ->assertSee('data-stat="barang">2</h3>', false)
            ->assertDontSee('Total User')
            ->assertDontSee('Total Kategori');
    }

    public function test_admin_can_open_barang_management_but_cannot_open_superadmin_pages(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $this->actingAs($admin)
            ->get('/admin/barang/index')
            ->assertOk()
            ->assertSee('Data Barang')
            ->assertSeeLivewire(AdminBarangIndex::class);

        $this->get('/superadmin/user/index')->assertForbidden();
        $this->get('/superadmin/kategori/index')->assertForbidden();
        $this->get('/superadmin/barang/index')->assertForbidden();
    }

    public function test_admin_can_create_barang_from_admin_livewire_page(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $kategori = new Kategori;
        $kategori->nama_kategori = 'Elektronik';
        $kategori->save();

        Livewire::actingAs($admin)
            ->test(AdminBarangIndex::class)
            ->set('kategori_id', (string) $kategori->id)
            ->set('nama_barang', 'Laptop')
            ->set('harga', '12500000')
            ->set('stok', '8')
            ->call('store')
            ->assertHasNoErrors()
            ->assertDispatched('close-create-modal');

        $this->assertDatabaseHas('barangs', [
            'kategori_id' => $kategori->id,
            'nama_barang' => 'Laptop',
            'harga' => '12500000.00',
            'stok' => 8,
        ]);
    }

    public function test_superadmin_cannot_open_admin_only_pages(): void
    {
        $superadmin = User::factory()->create(['role' => 'Super Admin']);

        $this->actingAs($superadmin)
            ->get('/admin/dashboard')
            ->assertForbidden();

        $this->get('/admin/barang/index')->assertForbidden();
    }

    public function test_superadmin_dashboard_and_navigation_remain_available(): void
    {
        $superadmin = User::factory()->create(['role' => 'Super Admin']);

        $this->actingAs($superadmin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee(route('superadmin.user.index'))
            ->assertDontSee(route('admin.barang.index'));
    }

    private function createKategori(string $namaKategori): Kategori
    {
        $kategori = new Kategori;
        $kategori->nama_kategori = $namaKategori;
        $kategori->save();

        return $kategori;
    }

    private function createBarang(Kategori $kategori, string $namaBarang): Barang
    {
        return Barang::query()->create([
            'kategori_id' => $kategori->id,
            'nama_barang' => $namaBarang,
            'harga' => 1000,
            'stok' => 1,
        ]);
    }
}
