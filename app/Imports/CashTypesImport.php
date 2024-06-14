<?php

namespace App\Imports;

use App\Models\CashType;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CashTypesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new CashType([
            'nama' => $row[1],
            'jenis' => $row[2],
            'keterangan' => $row[3]
        ]);
    }
}
