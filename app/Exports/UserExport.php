<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport extends SafeValueBinder implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(private readonly Builder $users) {}

    public function query(): Builder
    {
        return $this->users;
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return ['Nama', 'Email', 'Role'];
    }

    /**
     * @return array<int, string>
     */
    public function map($user): array
    {
        return [$user->nama, $user->email, $user->role];
    }
}
