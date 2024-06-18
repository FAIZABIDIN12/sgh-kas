<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\CashFlow;
use App\Models\CashType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class CashFlowsImport implements ToModel
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

            $cashType = CashType::whereRaw('LOWER(jenis) = ?', [$jenis])
                ->whereRaw('LOWER(nama) = ?', [$nama])
                ->first();

            if (!$cashType) {
                throw new Exception("CashType not found for jenis: {$jenis}, nama: {$nama}");
            }

            $tanggal = Carbon::createFromFormat('d/m/Y', $row[1])->format('Y-m-d');

            $cashFlow = new CashFlow([
                'tanggal' => $tanggal,
                'uraian' => $row[2],
                'nominal' => $row[3],
                'cash_type_id' => $cashType->id,
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
