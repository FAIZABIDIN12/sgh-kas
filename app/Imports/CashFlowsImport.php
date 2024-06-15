<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\CashFlow;

class CashFlowsImport implements ToModel
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {

        return new CashFlow([]);
    }
}
