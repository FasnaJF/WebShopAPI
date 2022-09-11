<?php

namespace App\Console\Commands;

use App\Imports\ProductsImport;
use App\Imports\UsersImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class importMasterData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Excel importer';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fail_count = 0;
        $this->output->title('Starting customers import');
        $import = new UsersImport();
        $import->withOutput($this->output)->import(storage_path('customers.csv'));
        $this->output->success('Import completed. See Log for unsuccessful entries.');

        foreach ($import->failures() as $failure) {
            $fail_count ++;
            Log::info($failure);
        }
        Log::info('Number of row(s) failed for customer import is: '.$fail_count);

        $fail_count = 0;
        $this->output->title('Starting products import');
        $import = new ProductsImport();
        $import->withOutput($this->output)->import(storage_path('products.csv'));
        $this->output->success('Import completed. See Log for unsuccessful entries.');

        foreach ($import->failures() as $failure) {
            $fail_count++;
            Log::info($failure);
        }
        Log::info('Number of row(s) failed for product import is: ' . $fail_count);

        return 'done';
    }
}
