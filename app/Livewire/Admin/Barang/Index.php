<?php

namespace App\Livewire\Admin\Barang;

use App\Livewire\Superadmin\Barang\Index as BarangIndex;

class Index extends BarangIndex
{
    protected function barangView(): string
    {
        return 'components.admin.barang.index';
    }
}
