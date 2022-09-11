<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithValidation, SkipsOnFailure
{

    use Importable,SkipsFailures;

    public function model(array $row)
    {
        return new Product([
            'product_name'     => $row['productname'],
            'price'    => $row['price'],
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            'productname' =>'required',
            'price' =>'required',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'productname' => 'Product name has to be a non empty value',
            'price' => 'Price has to be a non empty value',
        ];
    }
}
