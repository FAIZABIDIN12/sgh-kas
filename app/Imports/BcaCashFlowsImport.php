<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\BcaCashFlow;
use App\Models\BcaCashType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class BcaCashFlowsImport implements ToModel
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        DB::beginTransaction();

        try {
            $jenis = strtolower($row[4]);
            $nama = strtolower($row[5]);

            $bcaCashType = BcaCashType::whereRaw('LOWER(jenis) = ?', [$jenis])
                ->whereRaw('LOWER(nama) = ?', [$nama])
                ->first();

            if (!$bcaCashType) {
                throw new Exception("BcaCashType not found for jenis: {$jenis}, nama: {$nama}");
            }

            $tanggal = Carbon::createFromFormat('d/m/Y', $row[1])->format('Y-m-d');

            $cashFlow = new BcaCashFlow([
                'tanggal' => $tanggal,
                'uraian' => $row[2],
                'nominal' => $row[3],
                'bca_cash_type_id' => $bcaCashType->id,
                'user_id' => 1
            ]);

            DB::commit();

            return $cashFlow;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
