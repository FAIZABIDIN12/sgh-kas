<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CashType;

class CashTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Lainya', 'jenis' => 'Keluar'],
            ['nama' => 'Operasional', 'jenis' => 'Keluar'],
            ['nama' => 'Lainya', 'jenis' => 'Masuk'],
            ['nama' => 'Pendapatan OOD Laundry', 'jenis' => 'Masuk'],
            ['nama' => 'Pendapatan OOD Toko', 'jenis' => 'Masuk'],
            ['nama' => 'Pendapatan OOD Renang', 'jenis' => 'Masuk'],
            ['nama' => 'Pendapatan Payment Group', 'jenis' => 'Masuk'],
            ['nama' => 'DP Tamu Group', 'jenis' => 'Masuk'],
            ['nama' => 'WIG Payment', 'jenis' => 'Masuk'],
        ];

        foreach ($data as $item) {
            CashType::create($item);
        }
    }
}
