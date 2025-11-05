{{-- ============================================ --}}
{{-- resources/views/games/show.blade.php --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', $game->title)

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="w-48 h-48 bg-white rounded-lg flex items-center justify-center">
                @if($game->cover_image)
                    <img src="{{ asset('storage/' . $game->cover_image) }}" alt="{{ $game->title }}" class="w-full h-full object-cover rounded-lg">
                @else
                    <div class="text-white text-2xl font-bold">{{ substr($game->title, 0, 1) }}</div>
                @endif
            </div>
            <div class="flex-1">
                <h1 class="text-4xl font-bold mb-2">{{ $game->title }}</h1>
                <div class="flex items-center gap-4 mb-4">
                    <span class="bg-white text-indigo-600 px-4 py-1 rounded-full text-sm font-semibold">{{ $game->genre }}</span>
                    <span class="bg-white bg-opacity-20 px-4 py-1 rounded-full text-sm">{{ $game->platform }}</span>
                </div>
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400 mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($game->average_rating))
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @else
                                <svg class="w-6 h-6 fill-current text-white text-opacity-30" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-xl font-bold">{{ number_format($game->average_rating, 1) }}</span>
                    <span class="ml-2 text-sm opacity-80">({{ $game->total_reviews }} reviews)</span>
                </div>
                <div class="text-sm opacity-90">
                    <p><strong>Publisher:</strong> {{ $game->publisher ?? 'Unknown' }}</p>
                    <p><strong>Players:</strong> {{ $game->min_players }}-{{ $game->max_players }}</p>
                    @if($game->release_date)
                        <p><strong>Released:</strong> {{ $game->release_date->format('M d, Y') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">About</h2>
                <p class="text-gray-700 leading-relaxed">{{ $game->description }}</p>
            </div>

            <!-- Reviews -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">User Reviews</h2>
                    @auth
                        <button onclick="document.getElementById('reviewForm').scrollIntoView({behavior: 'smooth'})" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            Write Review
                        </button>
                    @endauth
                </div>

                @forelse($reviews as $review)
                    <div class="border-b pb-6 mb-6 last:border-0">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}" 
                                     alt="{{ $review->user->name }}" 
                                     class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <h4 class="font-bold">{{ $review->user->name }}</h4>
                                    <div class="flex text-yellow-400 text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                ⭐
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <h5 class="font-semibold mb-2">{{ $review->title }}</h5>
                        <p class="text-gray-700">{{ $review->review_text }}</p>
                        <div class="mt-3">
                            <form action="{{ route('games.reviews.helpful', $review->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-gray-600 hover:text-indigo-600">
                                    👍 Helpful ({{ $review->helpful_count }})
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-8">No reviews yet. Be the first to review!</p>
                @endforelse

                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>
            </div>

            <!-- Write Review Form -->
            @auth
                <div id="reviewForm" class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h3 class="text-xl font-bold mb-4">Write a Review</h3>
                    <form action="{{ route('games.reviews.store', $game->slug) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Rating</label>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                        <span class="text-3xl text-gray-300 peer-checked:text-yellow-400">⭐</span>
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Title</label>
                            <input type="text" name="title" class="w-full border rounded-lg px-4 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Review</label>
                            <textarea name="review_text" rows="4" class="w-full border rounded-lg px-4 py-2" required></textarea>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                            Submit Review
                        </button>
                    </form>
                </div>
            @endauth
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Rate This Game -->
            @auth
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-xl font-bold mb-4">Rate This Game</h3>
                    <form action="{{ route('games.rate', $game->slug) }}" method="POST">
                        @csrf
                        <div class="flex justify-center gap-2 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" 
                                           class="hidden peer" 
                                           {{ $userRating && $userRating->rating == $i ? 'checked' : '' }}>
                                    <span class="text-xl text-gray-300 peer-checked:text-yellow-400">★</span>
                                </label>
                            @endfor
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                            {{ $userRating ? 'Update Rating' : 'Submit Rating' }}
                        </button>
                    </form>
                </div>
            @endauth

            <!-- Tournaments -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Upcoming Tournaments</h3>
                @forelse($game->tournaments()->upcoming()->take(5)->get() as $tournament)
                    <div class="mb-4 pb-4 border-b last:border-0">
                        <h4 class="font-bold text-sm">{{ $tournament->name }}</h4>
                        <p class="text-xs text-gray-600">{{ $tournament->tournament_start->format('M d, Y') }}</p>
                        <a href="{{ route('tournaments.show', $tournament->slug) }}" class="text-xs text-indigo-600 hover:underline">
                            View Details →
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No upcoming tournaments</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection