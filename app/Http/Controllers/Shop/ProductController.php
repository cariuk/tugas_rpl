<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        protected Product $product)
    {
    }

    public function get(): JsonResponse
    {
        $collection = $this->product->get();

        return response()->json([
            "status" => "success",
            "data" => ProductResource::collection($collection),
        ]);
    }

    public function index($productId): \Inertia\Response
    {
        /*
         *  1. Harga Termurah
         *  2. Kinerja / Windows Experiens Index
         *  3. Bobot
         * */
        $data = $this->product->where('id', $productId)->firstOrFail();

        return Inertia::render('ProductDetail/Product', [
            'title' => "Product Detail",
            'product' => $data,
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
