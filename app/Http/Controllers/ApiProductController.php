<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Jobs\ImportProductJob;
use App\Services\ProductService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\File;
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
     * @param Request $request
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function store(Request $request)
    {
        if ($request->file('json_file') || count($request->json()) || $request->json) {
            if ($request->file('json_file')) {
                $file     = $request->file('json_file');
                $filename = time() . '-' . $file->getClientOriginalName();
                $data     = File::get($file);
            } else if ($request->json) {
                $data     = request()->get('json');
                $filename = time() . '-param' . '.json';
            } else {
                $data     = json_encode($request->json()->all());
                $filename = time() . '-json' . '.json';
            }

            $path = "import-product/{$filename}";
            Storage::disk('public')->put($path, $data);

            //dispatch the job for product import in db
            ImportProductJob::dispatch($filename);
            return response()->json(['message' => 'File Upload successfully']);
        } else {
            // return response()->json(['message' => 'File not found'], 404);
            return response()->json([
                'message' => 'Only allowed: Field JSON \n OR JSON file with extension .json \n OR JSON with Content type application/json'
            ], 400);
        }
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
