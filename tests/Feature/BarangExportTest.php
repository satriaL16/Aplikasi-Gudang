<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tests\TestCase;

class BarangExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_download_excel_with_matching_barang(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $elektronik = $this->createKategori('Elektronik');
        $perabot = $this->createKategori('Perabot');
        $this->createBarang($elektronik, 'Laptop', '12500000.50', 8);
        $this->createBarang($perabot, 'Meja', '850000.00', 3);

        $response = $this->actingAs($admin)->get(route('barang.export.excel', ['search' => 'Elektronik']));

        $response->assertDownload('data-barang.xlsx');

        $temporaryFile = tempnam(sys_get_temp_dir(), 'barang-export-');
        file_put_contents($temporaryFile, $response->streamedContent());

        try {
            Cell::setValueBinder(new DefaultValueBinder);
            $sheet = IOFactory::load($temporaryFile)->getActiveSheet();

            $this->assertSame(['Kategori', 'Nama Barang', 'Harga', 'Stok'], $sheet->rangeToArray('A1:D1')[0]);
            $this->assertSame(['Elektronik', 'Laptop'], $sheet->rangeToArray('A2:B2')[0]);
            $this->assertSame(12500000.5, $sheet->getCell('C2')->getValue());
            $this->assertSame(8, $sheet->getCell('D2')->getValue());
            $this->assertSame([null, null, null, null], $sheet->rangeToArray('A3:D3')[0]);
        } finally {
            unlink($temporaryFile);
        }
    }

    public function test_superadmin_can_download_pdf(): void
    {
        $superadmin = User::factory()->create(['role' => 'Super Admin']);
        $kategori = $this->createKategori('Elektronik');
        $this->createBarang($kategori, 'Laptop', '12500000.50', 8);

        $response = $this->actingAs($superadmin)->get(route('barang.export.pdf'));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    public function test_barang_export_endpoints_require_an_authorized_user(): void
    {
        $this->get(route('barang.export.pdf'))->assertRedirectToRoute('login');
        $this->get(route('barang.export.excel'))->assertRedirectToRoute('login');

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
