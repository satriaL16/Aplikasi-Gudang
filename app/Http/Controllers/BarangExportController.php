<?php

namespace App\Http\Controllers;

use App\Exports\BarangExport;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BarangExportController extends Controller
{
    public function pdf(Request $request)
    {
        $search = $this->validatedSearch($request);
        $barangs = $this->barangQuery($search)->get();

        return Pdf::loadView('exports.barang', compact('barangs'))
            ->setPaper('a4', 'landscape')
            ->download('data-barang.pdf');
    }

    public function excel(Request $request)
    {
        $search = $this->validatedSearch($request);

        return Excel::download(new BarangExport($this->barangQuery($search)), 'data-barang.xlsx');
    }

    private function validatedSearch(Request $request): string
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        return trim($validated['search'] ?? '');
    }

    private function barangQuery(string $search): Builder
    {
        return Barang::query()
            ->with('kategori')
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('nama_barang', 'like', "%{$search}%")
                        ->orWhereHas('kategori', function (Builder $query) use ($search): void {
                            $query->where('nama_kategori', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('nama_barang');
    }
}
