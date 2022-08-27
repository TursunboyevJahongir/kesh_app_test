<?php

namespace App\Http\Controllers;

use App\Core\Http\Controllers\CoreController as Controller;
use App\Core\Http\Requests\GetAllFilteredRecordsRequest;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(ProductService $service)
    {
        parent::__construct($service);
        $this->authorizeResource(Product::class, 'product');
    }

    public function index(GetAllFilteredRecordsRequest $request): JsonResponse
    {
        $products = $this->service->get($request);

        return $this->responseWith(compact('products'));
    }

    public function show(Product $Product, GetAllFilteredRecordsRequest $request): JsonResponse
    {
        $product = $this->service->show($Product, $request);

        return $this->responseWith(compact('product'));
    }


    public function store(ProductCreateRequest $request): JsonResponse
    {
        try {
            $product = $this->service->create($request)->loadMissing('mainImage');

            return $this->responseWith(compact('product'), 201);
        } catch (\Exception $e) {
            return $this->responseWith(code: $e->getCode(), message: $e->getMessage());
        }
    }

    public function update(Product $product, ProductUpdateRequest $request): JsonResponse
    {
        try {
            $this->service->update($product, $request);

            return $this->responseWith(code: 204);
        } catch (\Exception $e) {
            return $this->responseWith(code: $e->getCode(), message: $e->getMessage());
        }
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->service->delete($product);

        return $this->responseWith(code: 204);
    }
}
