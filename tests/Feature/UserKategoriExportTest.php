<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Tests\TestCase;

class UserKategoriExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_download_filtered_user_excel_without_password_data(): void
    {
        $superadmin = User::factory()->create(['role' => 'Super Admin']);
        User::factory()->create([
            'nama' => 'Budi Gudang',
            'email' => 'budi@example.test',
            'role' => 'Admin',
            'password' => 'secret-password',
        ]);
        User::factory()->create([
            'nama' => 'Siti Kantor',
            'email' => 'siti@example.test',
            'role' => 'Admin',
        ]);

        $this->actingAs($superadmin)
            ->get(route('superadmin.user.export.pdf', ['search' => 'Budi']))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $response = $this->actingAs($superadmin)->get(route('superadmin.user.export.excel', ['search' => 'Budi']));

        $response->assertDownload('data-user.xlsx');
        $sheet = $this->loadSheet($response->streamedContent());

        $this->assertSame(['Nama', 'Email', 'Role'], $sheet->rangeToArray('A1:C1')[0]);
        $this->assertSame(['Budi Gudang', 'budi@example.test', 'Admin'], $sheet->rangeToArray('A2:C2')[0]);
        $this->assertSame([null, null, null], $sheet->rangeToArray('A3:C3')[0]);
    }

    public function test_superadmin_can_download_filtered_category_pdf_and_excel(): void
    {
        $superadmin = User::factory()->create(['role' => 'Super Admin']);
        $kategori = new Kategori;
        $kategori->nama_kategori = 'Elektronik';
        $kategori->save();
        $kategoriLain = new Kategori;
        $kategoriLain->nama_kategori = 'Perabot';
        $kategoriLain->save();

        $pdfResponse = $this->actingAs($superadmin)->get(route('superadmin.kategori.export.pdf', ['search' => 'Elektro']));

        $pdfResponse->assertOk();
        $pdfResponse->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $pdfResponse->getContent());

        $excelResponse = $this->get(route('superadmin.kategori.export.excel', ['search' => 'Elektro']));

        $excelResponse->assertDownload('data-kategori.xlsx');
        $sheet = $this->loadSheet($excelResponse->streamedContent());

        $this->assertSame(['Nama Kategori'], $sheet->rangeToArray('A1:A1')[0]);
        $this->assertSame(['Elektronik'], $sheet->rangeToArray('A2:A2')[0]);
        $this->assertSame([null], $sheet->rangeToArray('A3:A3')[0]);
    }

    public function test_admin_cannot_access_user_or_category_export_endpoints(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $this->actingAs($admin)->get(route('superadmin.user.export.pdf'))->assertForbidden();
        $this->get(route('superadmin.user.export.excel'))->assertForbidden();
        $this->get(route('superadmin.kategori.export.pdf'))->assertForbidden();
        $this->get(route('superadmin.kategori.export.excel'))->assertForbidden();
    }

    public function test_superadmin_pages_link_to_user_and_category_exports(): void
    {
        $superadmin = User::factory()->create(['role' => 'Super Admin']);

        $this->actingAs($superadmin)
            ->get(route('superadmin.user.index'))
            ->assertOk()
            ->assertSee(route('superadmin.user.export.pdf'))
            ->assertSee(route('superadmin.user.export.excel'));

        $this->get(route('superadmin.kategori.index'))
            ->assertOk()
            ->assertSee(route('superadmin.kategori.export.pdf'))
            ->assertSee(route('superadmin.kategori.export.excel'));
    }

    private function loadSheet(string $content): Worksheet
    {
        $temporaryFile = tempnam(sys_get_temp_dir(), 'data-export-');
        file_put_contents($temporaryFile, $content);

        try {
            Cell::setValueBinder(new DefaultValueBinder);

            return IOFactory::load($temporaryFile)->getActiveSheet();
        } finally {
            unlink($temporaryFile);
        }
    }
}
