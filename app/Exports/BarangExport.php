<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class BarangExport extends DefaultValueBinder implements FromQuery, WithCustomValueBinder, WithHeadings, WithMapping
{
    public function __construct(private readonly Builder $barangs) {}

    public function query(): Builder
    {
        return $this->barangs;
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return ['Kategori', 'Nama Barang', 'Harga', 'Stok'];
    }

    /**
     * @return array<int, string|int>
     */
    public function map($barang): array
    {
        return [
            $barang->kategori->nama_kategori,
            $barang->nama_barang,
            (float) $barang->getRawOriginal('harga'),
            $barang->stok,
        ];
    }

    public function bindValue(Cell $cell, mixed $value): bool
    {
        if (is_string($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        if (is_int($value) || is_float($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
