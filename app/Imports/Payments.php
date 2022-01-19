<?php

namespace App\Imports;

use App\Models\payment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Payments implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new payment([
            'idNumber'=>$row[0],
            'installmentDueDate' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
            'amountPaid'   => $row[2],
            'paymentDate'  => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]),

        ]);


    }

}
