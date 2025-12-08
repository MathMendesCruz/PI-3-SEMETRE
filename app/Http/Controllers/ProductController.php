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
        
        $products = $query->paginate(12)->appends(request()->query());
        $selectedBrand = request('brand');
        return view('feminino', compact('products', 'selectedBrand'));
    }

    public function masculino()
    {
        $query = Product::where('category', 'masculino');
        
        // Filtro de marca via query string
        if (request('brand')) {
            $query->where('brand', request('brand'));
        }
        
        $products = $query->paginate(12)->appends(request()->query());
        $selectedBrand = request('brand');
        return view('masculino', compact('products', 'selectedBrand'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('detalhe-produto', compact('product'));
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
