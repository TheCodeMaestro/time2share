<x-app-layout>
    <section class="filter-header" name="header">
        <form method="GET" action="{{ route('dashboard') }}">
            @csrf
            <section class="filter">
                <section>
                    <input type="text" name="search" placeholder="Search here for a product..." class="inputfield" style="width: 300px; margin: 0px" value="{{ request('search') }}"/>
                </section>
                <section style="display: inline-flex; align-items: center;">
                    <!-- <section class="label">Category:</section> -->
                    <select id="category" name="category" class="inputfield" style="margin-left: 0.5rem; margin-bottom: 0rem;">
                        <option selected>Pick a category</option>
                        <option value="Gereedschap">Gereedschap</option>
                        <option value="Speelgoed">Speelgoed</option>
                        <option value="Meubel">Meubel</option>
                        <option value="Keuken apparatuur">Keuken apparatuur</option>
                        <option value="Anders">Anders</option>
                    </select>
                </section>
                <section>
                    <button class="primary-button" type="submit">Search</button>
                </section>
            </section>
        </form>
        <form method="GET" action="{{ route('dashboard') }}">
            @csrf
            <section>
                <button class="secondary-button" type="submit">Reset filters</button>
            </section>
        </form>
    </section>
    @if($products->isEmpty())
        <section class="center">
            <h2><i>No products have been found</i></h2>
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
                    @if(Auth::user() -> admin)
                        <section>
                            <x-dropdown align='top'>
                                <x-slot name="trigger">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="options-icon" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                                        @csrf
                                        @method('delete')
                                        <x-dropdown-link :href="route('products.destroy', $product)" onclick="event.preventDefault(); 
                                        this.closest('form').submit();">{{ __('Delete product') }}</x-dropdown-link>
                                    </form>
                                @if($product->user->blocked)
                                    <form method="POST" action="{{ route('users.unblockUser', $product->user) }}">
                                        @csrf
                                        <x-dropdown-link :href="route('users.unblockUser', $product->user)" onclick="event.preventDefault(); 
                                        this.closest('form').submit();">{{ __('Unblock user') }}</x-dropdown-link>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('users.blockUser', $product->user) }}">
                                        @csrf
                                        <x-dropdown-link :href="route('users.unblockUser', $product->user)" onclick="event.preventDefault(); 
                                        this.closest('form').submit();">{{ __('Block user') }}</x-dropdown-link>
                                    </form>
                                @endif
                                </x-slot>
                            </x-dropdown>
                        </section>
                    @endif
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
                        <img src="{{ $product->image_path }}" alt="Product Image">
                    @else
                        <h2>No image available</h2>
                    @endif
                </section>
            </section>
        @endif      
    @endforeach
</x-app-layout>
