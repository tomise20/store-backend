<?php

namespace App\Http\Controllers;

use App\Repository\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function list(Request $request): JsonResponse
    {
        $limit = getenv('PRODUCT_PAGE_LIMIT');
        $products = $this->productRepository->list($limit, (int) $request->query('page'));

        return response()->json([
            'products' => $products,
            'total' => $this->productRepository->count(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $limit = (int) getenv('PRODUCT_PAGE_LIMIT');

        return response()->json([
            'products' => $this->productRepository->findAllByName($limit, $request->query('q'), $request->query('page')),
            'total' => $this->productRepository->count($request->query('q'))
        ]);
    }
}
