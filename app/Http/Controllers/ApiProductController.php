<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Jobs\ImportProductJob;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApiProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $products = (new ProductService())->getAllProducts($request);
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->filled('json_data')) {
            $collection = collect($request->json_data);
            foreach ($collection->chunk(10000) as $item) {
                ImportProductJob::dispatch($item->toArray());
            }
            return response()->json(['message' => 'Data Inserting...']);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }

        //ImportProductJob::dispatch($request->json_data);
        /*foreach ($request->json_data as $item) {

        }*/
        /*dd(json_decode($request));
        foreach ($request as $item) {
            return $item;
        }*/
        //ImportProductJob::dispatch($request);
        /*if ($request->file('json_file')) {
            //uploading the file
            $file     = $request->file('json_file');
            $filename = time() . '-' . $file->getClientOriginalName();
            Storage::disk('public')->put("import-product/{$filename}", \File::get($file));

            //dispatch the job for product import in db
            ImportProductJob::dispatch($filename);
            return response()->json(['message' => 'File Upload successfully']);
        } else {
            return response()->json(['message' => 'File not found'], 404);
        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
