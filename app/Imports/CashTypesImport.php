<?php

namespace App\Imports;

use App\Models\CashType;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;

class CashTypesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $jenis = $this->convertJenis($row[1]);

        if ($jenis === null) {
            Log::error('Invalid value for jenis: ' . $row[1]);
            return null;
        }

        return new CashType([
            'nama' => $row[2],
            'jenis' => $jenis,
            'keterangan' => $row[3]
        ]);
    }

    private function convertJenis($jenisFromExcel)
    {
        $map = [
            'cr' => 'masuk',
            'db' => 'keluar',
        ];

        return $map[strtolower($jenisFromExcel)] ?? null;
    }
}
