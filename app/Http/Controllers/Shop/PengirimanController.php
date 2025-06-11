<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pengiriman\GetDomesticCostPengirimanRequest;
use App\Http\Requests\Pengiriman\GetLokasiPengirimanRequest;
use App\Models\Product;
use App\Services\DijkstraShippingService;
use App\Services\RajaOngkirService;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PengirimanController extends Controller
{
    public function __construct(
        protected Product                 $product,
        protected RajaOngkirService       $rajaOngkirService,
        protected DijkstraShippingService $dijkstraShippingService,
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

        $userPreferenceTime = (float)$request->input('prefer_time', 0.5); // Default: 50% waktu
        $userPreferenceCost = (float)$request->input('prefer_cost', 0.5); // Default: 50% biaya

        try {
            $bestOption = $this->dijkstraShippingService->findBestShippingOptionCombined(
                $collection,
                $userPreferenceTime,
                $userPreferenceCost
            );


            if ($bestOption) {
                $bestOption = [
                    'message' => "Rekomendasi Pengiriman Terbaik (Bobot Gabungan)",
                    'prefer_time' => $userPreferenceTime,
                    'prefer_cost' => $userPreferenceCost,
                    'recommended_option' => $bestOption
                ];
            } else {
                $bestOption = ['message' => 'Tidak ada opsi pengiriman yang ditemukan.'];
            }

        } catch (\InvalidArgumentException $e) {
            $bestOption = ['error' => $e->getMessage()];
        }


        return response()->json([
            "status" => 200,
            "data" => $collection,
            "best_option" => $bestOption
        ]);
    }
}
