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
                                    <!-- <p>{{ $product->image_path }}</p> -->
                                    <img src="{{ $product->image_path }}" alt="Girl in a jacket">
                                    <small class="text-sm text-gray-600">Posted on: {{ $product->created_at->format('j M Y, g:i a') }}</small>
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
                <input id="description" name="description" type="text" placeholder="A description of your product" 
                class="inputfield">
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
                <input id="image" name="image_path" type="file" accept=".jpg, .jpeg, .png" placeholder="A image of your product">
            </section>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Post product') }}</x-primary-button>
        </form>
    </section>    
</x-app-layout>