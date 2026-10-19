<?php

namespace Tests\Feature;

use App\Livewire\Auth\Index;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_livewire_auth_form(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Masuk untuk memulai sesi')
            ->assertSeeLivewire(Index::class);
    }

    public function test_valid_credentials_authenticate_user_and_redirect_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('secret-password'),
        ]);

        $this->withSession([]);

        Livewire::test(Index::class)
            ->set('email', ' Admin@Example.com ')
            ->set('password', 'secret-password')
            ->call('login')
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_are_rejected_with_a_generic_error(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('secret-password'),
        ]);

        Livewire::test(Index::class)
            ->set('email', 'admin@example.com')
            ->set('password', 'wrong-password')
            ->call('login')
            ->assertHasErrors('email')
            ->assertSee('Email atau password tidak sesuai.');

        $this->assertGuest();
    }

    public function test_login_rejects_missing_credentials(): void
    {
        Livewire::test(Index::class)
            ->call('login')
            ->assertHasErrors([
                'email' => 'required',
                'password' => 'required',
            ]);

        $this->assertGuest();
    }

    public function test_login_is_throttled_after_five_failed_attempts(): void
    {
        $component = Livewire::test(Index::class)
            ->set('email', 'admin@example.com');

        foreach (range(1, 5) as $attempt) {
            $component->set('password', 'wrong-password')->call('login');
        }

        $component->set('password', 'wrong-password')
            ->call('login')
            ->assertSee('Terlalu banyak percobaan masuk.');

        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_from_protected_pages(): void
    {
        $this->get('/superadmin/barang/index')
            ->assertRedirectToRoute('login');

        $this->get('/dashboard')
            ->assertRedirectToRoute('login');
    }

    public function test_authenticated_user_is_redirected_to_dashboard_from_root(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/')
            ->assertRedirectToRoute('dashboard');
    }

    public function test_authenticated_user_can_view_the_dashboard(): void
    {
        $user = User::factory()->create([
            'nama' => 'Admin Gudang',
            'role' => 'Super Admin',
            'email' => 'admin.gudang@example.com',
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Admin Gudang')
            ->assertSee('user-profile-dropdown', false)
            ->assertSee('Foto profil Admin Gudang')
            ->assertSee('admin.gudang@example.com')
            ->assertSee('Super Admin')
            ->assertSee('Keluar dari akun');
    }

    public function test_superadmin_dashboard_displays_total_barang_user_and_category_counts(): void
    {
        $superadmin = User::factory()->create(['role' => 'Super Admin']);
        User::factory()->count(2)->create();

        $kategori1 = $this->createKategori('Elektronik');
        $kategori2 = $this->createKategori('Makanan');
        $this->createBarang($kategori1, 'Laptop');
        $this->createBarang($kategori2, 'Kopi');
        $this->createBarang($kategori1, 'Monitor');

        $this->actingAs($superadmin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Total Data Barang')
            ->assertSee('data-stat="barang">3</h3>', false)
            ->assertSee('Total User')
            ->assertSee('data-stat="user">3</h3>', false)
            ->assertSee('Total Kategori')
            ->assertSee('data-stat="kategori">2</h3>', false);
    }

    public function test_logout_ends_the_authenticated_session(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/logout')
            ->assertRedirectToRoute('login');

        $this->assertGuest();
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
