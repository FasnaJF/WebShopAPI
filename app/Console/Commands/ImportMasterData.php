<?php

namespace App\Console\Commands;

use App\Imports\ProductsImport;
use App\Imports\UsersImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportMasterData extends Command
{
    protected $signature = 'import:data';

    protected $description = 'Laravel Excel importer';

    public function handle()
    {
        $customerImport = new UsersImport();
        $this->import('customers.csv', 'customers', $customerImport);

        $productImport = new ProductsImport();
        $this->import('products.csv', 'products', $productImport);
        return 'done';
    }

    private function import($file, $name, $import)
    {
        $fail_count = 0;
        $this->output->title('Starting ' . $name . ' import');
        $import->withOutput($this->output)->import(storage_path($file));
        $this->output->success('Import completed. See Log for unsuccessful entries.');

        foreach ($import->failures() as $failure) {
            $fail_count++;
            Log::info($failure);
        }
        Log::info('Number of row(s) failed for ' . $name . ' import is: ' . $fail_count);
    }
}
