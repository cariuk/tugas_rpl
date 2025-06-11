<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pengiriman\GetDomesticCostPengirimanRequest;
use App\Http\Requests\Pengiriman\GetLokasiPengirimanRequest;
use App\Http\Resources\Pengiriman\GetLokasiResource;
use App\Models\Product;
use App\Services\RajaOngkirService;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PengirimanController extends Controller
{
    public function __construct(
        protected Product           $product,
        protected RajaOngkirService $rajaOngkirService
    )
    {
    }

    public function index($productId): \Inertia\Response
    {
        $data = $this->product->where('id', $productId)->firstOrFail();

        return Inertia::render('ProductDetail/Pengiriman', [
            'title' => "Product Detail",
            'product' => $data,
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function getLokasi(GetLokasiPengirimanRequest $request): JsonResponse
    {
        $collection = Cache::remember("collection_location", 3600, function () use ($request) {
            return $this->rajaOngkirService->getDestination($request);
        });

        return response()->json([
            "status" => 200,
            "data" => $collection
        ]);
    }

    public function getDomesticCost(GetDomesticCostPengirimanRequest $request): JsonResponse
    {
        $collection = Cache::remember("collection_domestic_cost", 3600, function () use ($request) {
            return $this->rajaOngkirService->getDomesticCost($request);
        });

        return response()->json([
            "status" => 200,
            "data" => $collection
        ]);
    }
}
