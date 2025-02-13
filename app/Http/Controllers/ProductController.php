<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('products.myProducts', [
            'products' => Product::with('user')->latest()->get(),
        ]);
    }

    public function dashboard(): View
    {
        return view('dashboard', [
            'products' => Product::with('user')->latest()->get(),
        ]);
    }

    public function loan(Request $request, Product $product): RedirectResponse
    {   
        $product->update([
            'loaner_id' => auth()->id(),
            'status' => 'borrowed']);
            
        return redirect()->route('dashboard')->with('success', 'Product loaned successfully!');
    }

    public function return(Request $request, Product $product): RedirectResponse
    {   
        $product->update([
            // 'loaner_id' => null, //Tijdelijk voor testen, moet weg gehaald worden
            'status' => 'pending']);
            
        return redirect()->route('products.index')->with('success', 'Product is pending!');
    }

    public function accept(Request $request, Product $product): RedirectResponse
    {   
        $product->update([
            'loaner_id' => null,
            'status' => 'available']);
            
        return redirect()->route('products.index')->with('success', 'Product returned successfully!');
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'deadline' => 'required|date',
            // 'loaner_id' => 'required|string|max:255',
            // 'status' => 'required|string|in:available,borrowed',
            'image_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('images', 'public'); // Storage/app/public/images
            $validated['image_path'] = $path;
        } else {
            $validated['image_path'] = null;
        }

        $validated['user_id'] = auth()->id();

        Product::create($validated);

        // $request->user()->products()->create($validated);
 
        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        Gate::authorize('delete', $product);
 
        $product->delete();
 
        return redirect(route('products.index'));
    }
}
