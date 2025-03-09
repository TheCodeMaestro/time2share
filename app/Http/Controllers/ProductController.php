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
    public function index(): View
    {   
        return view('products.myProducts', [
            'products' => Product::with('user')->latest()->get(),
        ]);
    }

    public function dashboard(Request $request): View
    {
        $filter = Product::with('user')->latest();

        if ($request->filled('search')) {
            $filter->where('name', 'like', '%' . $request->search . '%')->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $filter->where('category', 'like', $request->category);
        }

        return view('dashboard', [
            'products' => $filter->get(),
        ]);
    }

    public function showPendingProducts(): View
    {   
        $products = Product::with('user')->where('status', 'pending')->latest()->get();

        return view('products.myProducts', [
            'products' => $products,
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
            'status' => 'pending']);
            
        return redirect()->route('products.index')->with('success', 'Product is pending!');
    }

    public function accept(Product $product): RedirectResponse
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

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:255',
            'deadline' => 'required|date',
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

    public function destroy(Product $product): RedirectResponse
    {   
        // Gate::authorize('delete', $product);
        $product->delete();
 
        return back();
    }
}