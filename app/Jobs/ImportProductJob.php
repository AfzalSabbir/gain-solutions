<?php

namespace App\Jobs;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$json_data = Storage::disk('public_uploads')->files('uploads', 'importData.json');
        $path        = public_path() . "/uploads/importData.json";
        $json_values = json_decode(file_get_contents($path), true);
        foreach ($json_values as $json_value) {
            $category = Category::firstOrCreate(['title' => $json_value['CATEGORY']]);
            $product  = $category->products()->create([
                'title'        => $json_value['NAME'],
                'product_type' => $json_value['PRODUCT_TYPE'],
            ]);
            $product->productVariants()->create([
                'sku'     => $json_value['SKU'],
                'barcode' => $json_value['BARCODE'],
                'price'   => $json_value['PRICE'] ?? 0,
            ]);
        }
    }
}
