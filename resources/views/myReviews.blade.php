<x-app-layout>
    <section class="reviews-layout">
        <section>
            <h2 style="text-align: center">Received reviews</h2>
            @foreach ($reviews as $review)
                @if($review->reviewed_user_id == Auth::user()->id)    
                    <section class="review-box">
                        <section class="review-header1">
                            <h2>{{ $review->title }}</h2>
                            <p>Score: {{$review->score}}/5</p>
                        </section>
                        <section class="review-header2">
                            <p>Writer: {{ $review->reviewer->name }}<br>
                            Posted on: {{ $review->created_at->format('j M Y, g:i a') }}<br>
                            @if($review->product_id != null)
                                Product: {{$review->product->name}}
                            @endif
                            </p>
                        </section>
                        <section class="review-message">
                            <p>{{ $review->message }}</p>
                        </section>
                    </section>
                @endif    
            @endforeach
        </section>
        <section>
            <h2 style="text-align: center">Written reviews</h2>
            @foreach ($reviews as $review)
                @if($review->reviewer_id == Auth::user()->id)    
                    <section class="review-box">
                        <section class="review-header1">
                            <h2>{{ $review->title }}</h2>
                            <p>Score: {{$review->score}}/5</p>
                        </section>
                        <section class="review-header2">
                            <p>Receiver: {{ $review->reviewedUser->name }}<br>
                            Posted on: {{ $review->created_at->format('j M Y, g:i a') }}<br>
                            @if($review->product_id != null)
                                Product: {{$review->product->name}}
                            @endif
                            </p>
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
                                        <form method="POST" action="{{ route('reviews.destroy', $review->id) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('reviews.destroy', $review)" onclick="event.preventDefault(); 
                                            this.closest('form').submit();">{{ __('Delete') }}</x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </section>
                        </section>
                        <section class="review-message">
                            <p>{{ $review->message }}</p>
                        </section>
                    </section>
                @endif    
            @endforeach
        </section>
    </section>  
    @if($reviews->isEmpty())
        <section class="center">
            <h2><i>You have no reviews</i></h2>
        </section>
    @endif  
</x-app-layout>