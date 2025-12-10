<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('index', compact('products'));
    }

    public function feminino()
    {
        $query = Product::where('category', 'feminino');

        // Filtro de marca via query string
        if (request('brand')) {
            $query->where('brand', request('brand'));
        }

        // Filtro de cor
        if (request('color')) {
            $query->where('color', request('color'));
        }

        // Filtro de preço
        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }
        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        $products = $query->paginate(12)->appends(request()->query());
        $selectedBrand = request('brand');
        $selectedColor = request('color');

        return view('feminino', compact('products', 'selectedBrand', 'selectedColor'));
    }

    public function masculino()
    {
        $query = Product::where('category', 'masculino');

        // Filtro de marca via query string
        if (request('brand')) {
            $query->where('brand', request('brand'));
        }

        // Filtro de cor
        if (request('color')) {
            $query->where('color', request('color'));
        }

        // Filtro de preço
        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }
        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        $products = $query->paginate(12)->appends(request()->query());
        $selectedBrand = request('brand');
        $selectedColor = request('color');

        return view('masculino', compact('products', 'selectedBrand', 'selectedColor'));
    }

    public function show($id)
    {
        $product = Product::with('approvedReviews.user')->findOrFail($id);
        return view('detalhe-produto', compact('product'));
    }

    public function search()
    {
        $query = Product::query();
        $searchTerm = request('q');

        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('brand', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtros adicionais
        if (request('category')) {
            $query->where('category', request('category'));
        }
        if (request('brand')) {
            $query->where('brand', request('brand'));
        }
        if (request('color')) {
            $query->where('color', request('color'));
        }
        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }
        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        $products = $query->paginate(12)->appends(request()->query());

        return view('search_results', compact('products', 'searchTerm'));
    }

    public function getProducts($category = null)
    {
        $query = Product::query();

        if ($category && $category !== 'todos') {
            $query->where('category', $category);
        }

        // Filtro de preço
        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        // Filtro de cor (simulado - em um banco real seria um campo)
        if (request('color')) {
            // Implementar lógica de filtro de cor se necessário
        }

        $products = $query->get();

        return response()->json([
            'products' => $products,
            'total' => $products->count()
        ]);
    }
}
