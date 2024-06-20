<?php

namespace App\Imports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class InvoicesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            // Konversi Excel Serial Date ke format tanggal
            $tglCheckin = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_ci']))->format('Y-m-d');
            $tglCheckout = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_co']))->format('Y-m-d');

            return new Invoice([
                'nama_tamu' => $row['nama_tamu'],
                'tgl_checkin' => $tglCheckin,
                'tgl_checkout' => $tglCheckout,
                'pax' => $row['pax'],
                'tagihan' => (float) str_replace('.', '', $row['tagihan']),
                'sp' => $row['sp'],
                'fo' => auth()->user()->name,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to import row: ' . json_encode($row) . ' Error: ' . $e->getMessage());
            return null;
        }
    }

    // Batasi jumlah baris per batch
    public function batchSize(): int
    {
        return 100;
    }

    // Batasi jumlah baris per chunk
    public function chunkSize(): int
    {
        return 100;
    }
}
