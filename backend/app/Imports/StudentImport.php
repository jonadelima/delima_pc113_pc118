<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public $rows;

    public function collection(Collection $collection)
    {
        $this->rows = $collection->skip(0);


    }
}
