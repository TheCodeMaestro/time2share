<x-app-layout>
    <x-slot name="header">
        <button type="button" class="header-button {{ request()->routeIs('products.index') ? 'active' : '' }}" onclick="window.location.href='{{ route('products.index') }}'">My products</button>
        <button type="button" class="header-button {{ request()->routeIs('showPendingProducts') ? 'active' : '' }}" onclick="window.location.href='{{ route('showPendingProducts') }}'">Pending products</button>
        <button onclick="openForm('newProduct')" type="button" class="header-button">New product</button>
    </x-slot>
    @if($products->isEmpty())
        <section class="center">
            <h2><i>You have no (pending) products</i></h2>
        </section>
    @endif
    @foreach ($products as $product)
        @if($product->owner->is(Auth::user()) Or $product->loaner_id == Auth::user()->id)
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
                    @if($product->loaner_id == Auth::user()->id And $product->status != "pending")
                        <form action="{{ route('products.return', $product->id) }}" method="POST">
                            @csrf
                            <button type="button" class="primary-button" style="margin: 4px 0px" onclick="openConfirmation({{ $product->id }})">Return product</button>
                            <section id="{{ $product->id }}" class="confirmation-popup">
                                <p>Are you sure that you want to return this product?<br>
                                You have until <b>{{$product->deadline}}</b> to return the product.<br>
                                <button class="secondary-button" type="button" style="margin: 0 0.25rem" onclick="closeConfirmation({{ $product->id }})">Cancel</button>
                                <button class="primary-button" type="submit" style="margin: 0 0.25rem">Confirm</button>
                                </p>
                            </section>
                        </form>
                    @endif
                    @if($product->owner->is(Auth::user()) And $product->status == "pending")
                        <form action="{{ route('products.accept', $product->id) }}" method="POST">
                            @csrf
                            <button type="button" class="primary-button" style="margin: 4px 0px" onclick="openConfirmation({{ $product->id }})">Accept return</button>
                            <section id="{{ $product->id }}" class="confirmation-popup">
                                <p>Are you sure that you want to accept the return of this product?<br>
                                <button class="secondary-button" type="button" style="margin-top: 0.25rem" onclick="closeConfirmation({{ $product->id }})">Cancel</button>
                                <button class="secondary-button" type="button" style="margin-top: 0.25rem" onclick="openForm('newReview', {{ $product->id }})">Confirm + review</button>
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
    <section class="overlay" id="overlay">
        <section class="product-form" id="newProduct">
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
                    <label for="category">Category</label><br>
                    <select id="category" name="category" class="inputfield">
                      <option value="Gereedschap">Gereedschap</option>
                      <option value="Speelgoed">Speelgoed</option>
                      <option value="Meubel">Meubel</option>
                      <option value="Keuken apparatuur">Keuken apparatuur</option>
                      <option value="Anders" selected>Anders</option>
                    </select>
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
                <section class="space-between">
                    <button class="secondary-button" type="button" style="margin-top: 20px" onclick="closeForm('newProduct')">cancel</button>
                    <button class="primary-button" type="submit" style="margin-top: 20px">{{ __('Post product') }}</button>
                </section>
            </form>
        </section>
        <section class="review-form" id="newReview">
            <form method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">
                @csrf
                <section>
                    <input type="hidden" name="product_id" id="product_id">
                </section>
                <section>
                    <label for="title">Title</label>
                    <input id="title" name="title" type="text" maxlength="255" placeholder="The titel of your review" 
                    required class="inputfield">
                </section>
                <section>
                    <label for="message">Review</label>
                    <textarea id="message" name="message" placeholder="Write your review here" 
                    class="inputfield" rows="4" cols="50"></textarea>
                </section>
                <p class="label">Score</p>
                <section id=scoreInput>
                    <input type="radio" id="one" name="score" value="1">
                    <label for="one">1</label>
                    <input type="radio" id="two" name="score" value="2">
                    <label for="two">2</label>
                    <input type="radio" id="three" name="score" value="3">
                    <label for="three">3</label>
                    <input type="radio" id="four" name="score" value="4">
                    <label for="four">4</label>
                    <input type="radio" id="five" name="score" value="5">
                    <label for="five">5</label>
                </section>
                <section class="space-between">
                    <button class="secondary-button" type="button" style="margin-top: 20px" onclick="closeForm('newReview')">cancel</button>
                    <button class="primary-button" type="submit" style="margin-top: 20px">Post review</button>
                </section> 
            </form>
        </section>
    </section>    
</x-app-layout>