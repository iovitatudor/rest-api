<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductArchiveRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(Request $request)
    {
        return ProductResource::collection(
            Product::sort()
                ->filterPrice()
                ->filterActive()
                ->paginate($request->get('limit') ?? 15)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return JsonResource
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductStoreRequest $request
     * @param Product $product
     * @return JsonResource
     */
    public function update(ProductStoreRequest $request, Product $product)
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response('deleted', 204);
    }

    /**
     * @param ProductArchiveRequest $request
     * @param Product $product
     * @return JsonResource
     */
    public function archive(ProductArchiveRequest $request, Product $product)
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }
}
