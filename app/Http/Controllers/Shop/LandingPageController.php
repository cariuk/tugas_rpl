<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;

class LandingPageController extends Controller
{
    public function __construct(
        protected Product $product,
    )
    {
    }

    public function index(): \Inertia\Response
    {
        return Inertia::render('LandingPage/Welcome', [
            'title' => "Welcome",
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
