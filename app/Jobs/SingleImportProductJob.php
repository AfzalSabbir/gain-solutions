<?php

namespace App\Jobs;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SingleImportProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $json_value;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($json_value)
    {
        $this->json_value = $json_value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $json_value = $this->json_value;

        DB::beginTransaction();
        $category = Category::query()->firstOrCreate(['title' => $json_value['CATEGORY']]);
        $product  = $category->products()->create([
            'title'        => $json_value['NAME'],
            'product_type' => $json_value['PRODUCT_TYPE'],
        ]);
        $product->productVariants()->create([
            'sku'     => $json_value['SKU'],
            'barcode' => $json_value['BARCODE'],
            'price'   => $json_value['PRICE'] ?? 0,
        ]);
        DB::commit();
    }
}
