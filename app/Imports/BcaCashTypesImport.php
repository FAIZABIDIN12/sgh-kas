<?php

namespace App\Imports;

use App\Models\BcaCashType;
use Maatwebsite\Excel\Concerns\ToModel;

class BcaCashTypesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new BcaCashType([
            'nama' => $row[1],
            'jenis' => $row[0],
            'keterangan' => $row[2]
        ]);
    }
}
