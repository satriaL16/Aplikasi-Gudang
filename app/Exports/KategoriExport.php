<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KategoriExport extends SafeValueBinder implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(private readonly Builder $kategoris) {}

    public function query(): Builder
    {
        return $this->kategoris;
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return ['Nama Kategori'];
    }

    /**
     * @return array<int, string>
     */
    public function map($kategori): array
    {
        return [$kategori->nama_kategori];
    }
}
