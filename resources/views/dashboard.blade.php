<x-app-layout>
    <section class="filter-header" name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2> -->
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">Filters</h2> -->
        <form method="GET" action="{{ route('dashboard') }}">
            @csrf
            <section style="display: inline-flex; gap: 8px; align-items: center;">
                <input type="text" name="search" placeholder="Search here for a product..." class="inputfield" style="width: 300px; margin: 0px" value="{{ request('search') }}"/>
                <button class="primary-button" type="submit">Search</button>
            </section>
        </form>
        <form method="GET" action="{{ route('dashboard') }}">
            @csrf
            <section style="display: inline-flex; gap: 8px; align-items: center;">
                <button class="primary-button" type="submit">Reset filters</button>
            </section>
        </form>
    </section>
    @if($products->isEmpty())
        <section class="center">
            <h2>No products have been found</h2>
        </section>
    @endif
    @foreach ($products as $product)
        @if($product->status == "available")
            <section class="product-box">
                <section class="product-header1">
                    <h2>{{ $product->name }}</h2>
                    <p>Category: {{ $product->category }} | Deadline: {{ $product->deadline }}</p>
                </section>
                <section class="product-header2">
                    <p>Owner: {{ $product->user->name }}<br>
                    Posted on: {{ $product->created_at->format('j M Y, g:i a') }}<br>
                    Status: {{ $product->status }}</p>
                </section>
                <section class="product-description">
                    <p>{{ $product->description }}</p>
                    @if($product->owner != Auth::user())
                        <form action="{{ route('products.loan', $product->id) }}" method="POST">
                            @csrf
                            <button type="button" class="primary-button" style="margin: 4px 0px" onclick="openConfirmation({{ $product->id }})">Loan Product</button>
                            <section id="{{ $product->id }}" class="confirmation-popup">
                                <p>Are you sure that you want to loan this product?<br>
                                You will need to return the product before <b>{{$product->deadline}}</b>
                                <button class="secondary-button" type="button" style="margin-top: 0.25rem" onclick="closeConfirmation({{ $product->id }})">Cancel</button>
                                <button class="primary-button" type="submit" style="margin-top: 0.25rem">Confirm</button>
                                </p>
                            </section>
                        </form>
                    @endif
                </section>
                <section class="product-image">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="Product Image">
                    @else
                        <h2>No image available</h2>
                    @endif
                </section>
            </section>
        @endif      
    @endforeach
</x-app-layout>
