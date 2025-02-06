<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My products</h2>
    </x-slot>
    @foreach ($products as $product)
        @if($product->owner->is(Auth::user()))
            <section class="product-box">
                <section class="product-header1">
                    <h2>{{ $product->name }}</h2>
                    <p>Category: {{ $product->category }} | Deadline: {{ $product->deadline }}</p>
                </section>
                <section class="product-header2">
                    <p>Owner: {{ $product->user->name }}<br>
                    Posted on: {{ $product->created_at->format('j M Y, g:i a') }}<br>
                    Status: {{ $product->status }}</p>
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
                                    this.closest('form').submit();">{{ __('Delete') }}</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </section>
                </section>
                <section class="product-description">
                    <p>{{ $product->description }}</p>
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

    <section class="product-form-tijdelijk">
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf
            <section>
                <label for="name">Name </label>
                <input id="name" name="name" type="text" maxlength="255" placeholder="The name of your product" 
                required class="inputfield">
            </section>
            <section>
                <label for="description">Description </label>
                <textarea id="description" name="description" placeholder="A description of your product" 
                class="inputfield" rows="4" cols="50"></textarea>
            </section>
            <section>
                <label for="category">Category </label>
                <input id="category" name="category" type="text" placeholder="The category your product falls under" 
                required class="inputfield">
            </section>
            <section>
                <label for="deadline">Deadline </label>
                <input id="deadline" name="deadline" type="date" placeholder="The date your product needs to be returned" 
                required class="inputfield">
            </section>
            <section>
                <label for="image">Product image </label><br>
                <input id="image" name="image_path" type="file" placeholder="A image of your product">
            </section>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <button class="primary-button" style="margin-top: 20px">{{ __('Post product') }}</button>
        </form>
    </section>    
</x-app-layout>