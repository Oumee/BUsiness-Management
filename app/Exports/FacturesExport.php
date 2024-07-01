<?php

namespace App\Exports;

use App\Models\factures;
use Maatwebsite\Excel\Concerns\FromCollection;

class FacturesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return factures::all();
    }
}
