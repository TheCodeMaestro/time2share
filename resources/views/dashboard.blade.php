<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <section>
        <!-- @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif -->
    </section>
    @foreach ($products as $product)
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
                <form action="{{ route('products.loan', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="primary-button" style="margin: 4px 0px">Loan Product</button>
                </form>
                <!-- <p>{{ route('products.loan', $product->id) }}</p> -->
            </section>
            <section class="product-image">
                @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="Product Image">
                @else
                    <h2>No image available</h2>
                @endif
            </section>
        </section>  
    @endforeach
    <!-- <section>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </section> -->
</x-app-layout>
