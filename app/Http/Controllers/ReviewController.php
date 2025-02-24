<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {   
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
            'score' => 'required|integer|min:1|max:5',
            'product_id' => 'nullable|exists:products,id'
        ]);

        $product = Product::find($validated['product_id']);
        if (!$product) {
            dd('Product niet gevonden', $validated['product_id']);
        }
        
        $validated['reviewer_id'] = auth()->id();
        $validated['reviewed_user_id'] = $product->loaner_id;

        Review::create($validated);

        $productController = app(ProductController::class);
        $productController->accept($product);

        return redirect()->route('showPendingProducts');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
