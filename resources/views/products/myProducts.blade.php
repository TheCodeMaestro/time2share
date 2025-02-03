<x-app-layout>
    <section class="product-container-tijdelijk">
        <section class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($products as $product)
                @if($product->owner->is(Auth::user()))
                    <section class="p-6 flex space-x-2">
                        <section class="flex-1">
                            <section class="flex justify-between items-center">
                                <section>
                                    <h2>{{ $product->name }}</h2>
                                    <p>Category: {{ $product->category }}</p>
                                    <p>Description: {{ $product->description }}</p>
                                    <p>Status: {{ $product->status }}</p>
                                    <p>Owner: {{ $product->user->name }}</p>
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="Product Image">
                                    @endif
                                    <small class="text-sm text-gray-600">Posted on: {{ $product->created_at->format('j M Y, g:i a') }}</small>
                                    <!-- <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-primary-button class="mt-4">Delete product</x-primary-button>
                                    </form> -->

                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                                                @csrf
                                                @method('delete')
                                                <x-dropdown-link :href="route('products.destroy', $product)" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Delete') }}</x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>

                                </section>
                            </section>
                        </section>
                    </section>
                @endif    
            @endforeach
    </section>
    </section>
    <section class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf
            <section>
                <label for="name">Name </label>
                <input id="name" name="name" type="text" placeholder="The name of your product" 
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
            <x-primary-button class="mt-4">{{ __('Post product') }}</x-primary-button>
        </form>
    </section>    
</x-app-layout>