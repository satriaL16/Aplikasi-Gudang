<?php

namespace App\Http\Controllers;

use App\Exports\KategoriExport;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KategoriExportController extends Controller
{
    public function pdf(Request $request)
    {
        $kategoris = $this->kategoriQuery($this->validatedSearch($request))->get();

        return Pdf::loadView('exports.kategori', compact('kategoris'))
            ->setPaper('a4')
            ->download('data-kategori.pdf');
    }

    public function excel(Request $request)
    {
        return Excel::download(
            new KategoriExport($this->kategoriQuery($this->validatedSearch($request))),
            'data-kategori.xlsx',
        );
    }

    private function validatedSearch(Request $request): string
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        return trim($validated['search'] ?? '');
    }

    private function kategoriQuery(string $search): Builder
    {
        return Kategori::query()
            ->when($search !== '', fn (Builder $query) => $query->where('nama_kategori', 'like', "%{$search}%"))
            ->orderBy('nama_kategori');
    }
}
