<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

class PengirimanController extends Controller
{
    public function __construct(
        protected Product $product)
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

    public function getLokasi()
    {
        return response()->json([
            "status" => 200,
            "data" => []
        ]);
    }
}
