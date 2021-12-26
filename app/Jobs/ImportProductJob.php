<?php

namespace App\Jobs;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (Storage::disk('public')->exists("import-product/{$this->file_name}")) {
            $json_data   = Storage::disk('public')->get("import-product/{$this->file_name}");
            $json_values = json_decode($json_data, true);
            $this->importProducts($json_values);
        }
    }

    /**
     * import products in database
     *
     * @param $json_values
     * @return void
     */
    private function importProducts($json_values)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        foreach ($json_values as $json_value) {
            SingleImportProductJob::dispatch($json_value);
        }
    }
}
