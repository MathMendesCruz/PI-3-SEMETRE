<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Você precisa estar logado para comentar',
            ], 401);
        }

        $product = Product::findOrFail($productId);

        // Verificar se o usuário já comprou o produto
        if (!Auth::user()->hasOrderedProduct($productId)) {
            return response()->json([
                'success' => false,
                'message' => 'Você só pode comentar produtos que já comprou',
            ], 403);
        }

        // Verificar se já comentou
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Você já comentou este produto',
            ], 400);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'approved' => false, // Requer aprovação
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comentário enviado! Aguardando aprovação.',
            'review' => $review,
        ]);
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['approved' => true]);

        return back()->with('success', 'Comentário aprovado!');
    }

    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Comentário rejeitado!');
    }

    public function index()
    {
        $reviews = Review::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin_reviews', compact('reviews'));
    }
}
