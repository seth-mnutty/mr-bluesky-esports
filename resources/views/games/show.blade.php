@extends('layouts.app')

@section('title', $game->title . ' -* BLUESKY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Game Header -->
        <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="md:flex">
                <div class="md:w-1/3">
                    <div class="h-64 md:h-full bg-gradient-to-br from-sky-900/40 to-blue-900/20 flex items-center justify-center relative overflow-hidden">
                        @if($game->cover_image)
                            @php
                                $imageUrl = filter_var($game->cover_image, FILTER_VALIDATE_URL) 
                                    ? $game->cover_image 
                                    : asset('storage/' . $game->cover_image);
                            @endphp
                            <img src="{{ $imageUrl }}" 
                                 alt="{{ $game->title }}" 
                                 class="w-full h-full object-cover opacity-90"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden text-sky-400 text-5xl font-black">{{ substr($game->title, 0, 1) }}</div>
                        @else
                            <div class="text-sky-400 text-5xl font-black">{{ substr($game->title, 0, 1) }}</div>
                        @endif
                    </div>
                </div>
                <div class="md:w-2/3 p-8">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-4xl sm:text-5xl font-black text-white mb-3 uppercase tracking-tight">{{ $game->title }}</h1>
                            <div class="flex items-center space-x-4 text-sm">
                                <span class="bg-sky-900/50 text-sky-400 px-3 py-1 rounded-full border border-sky-800/50 uppercase font-bold">{{ $game->genre }}</span>
                                <span class="text-gray-400">{{ $game->platform }}</span>
                                @if($game->publisher)
                                    <span class="text-gray-400">by {{ $game->publisher }}</span>
                                @endif
                            </div>
                        </div>
                        @auth
                            @if(auth()->user()->id === $game->created_by || auth()->user()->role === 'admin')
                                <div class="flex space-x-2">
                                    <a href="{{ route('games.edit', $game->slug) }}" class="bg-gray-800 border border-sky-900/30 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition text-sm font-bold">Edit</a>
                                </div>
                            @endif
                        @endauth
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($game->average_rating ?? 0))
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 fill-current text-gray-700" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="ml-3 text-xl font-black text-white">{{ number_format($game->average_rating ?? 0, 1) }}</span>
                            <span class="ml-2 text-sm text-gray-400">({{ $reviews->total() }} reviews)</span>
                        </div>
                        
                        @auth
                            @if(!$userRating)
                                <form action="{{ route('games.rate', $game->slug) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    <select name="rating" class="bg-gray-900 border border-sky-900/30 rounded-lg px-3 py-2 text-sm text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                                        <option value="">Rate this game</option>
                                        @for($i = 5; $i >= 1; $i--)
                                            <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-4 py-2 rounded-lg hover:from-sky-500 hover:to-blue-600 transition text-sm font-bold border border-sky-500/50">Submit</button>
                                </form>
                            @else
                                <p class="text-sm text-gray-400">You rated this game: <span class="text-sky-400 font-bold">{{ $userRating->rating }} stars</span></p>
                            @endif
                        @endauth
                    </div>
                    
                    <div class="prose max-w-none">
                        <p class="text-gray-300 text-lg leading-relaxed">{{ $game->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Reviews</h2>
            
            @auth
                <form action="{{ route('games.reviews.store', $game->slug) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="title" class="w-full bg-gray-900 border border-sky-900/30 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 placeholder-gray-500" placeholder="Review Title" required>
                    </div>
                    <div class="mb-4">
                        <select name="rating" class="w-full bg-gray-900 border border-sky-900/30 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
                            <option value="">Select Rating</option>
                            <option value="5">5 Stars - Excellent</option>
                            <option value="4">4 Stars - Good</option>
                            <option value="3">3 Stars - Average</option>
                            <option value="2">2 Stars - Poor</option>
                            <option value="1">1 Star - Terrible</option>
                        </select>
                    </div>
                    <textarea name="review_text" rows="4" class="w-full bg-gray-900 border border-sky-900/30 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 placeholder-gray-500" placeholder="Write your review (min 10 characters)..." required></textarea>
                    <div class="mt-3 flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-6 py-2.5 rounded-lg hover:from-sky-500 hover:to-blue-600 transition font-bold border border-sky-500/50">Submit Review</button>
                    </div>
                </form>
            @endauth

            <div class="space-y-6">
                @forelse($reviews as $review)
                    <div class="border-b border-sky-900/30 pb-6 last:border-0 last:pb-0">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-sky-600 to-blue-700 rounded-full flex items-center justify-center border border-sky-500/50">
                                    <span class="text-white font-bold">{{ substr($review->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-bold text-white">{{ $review->user->name }}</p>
                                    <p class="text-sm text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-300 mt-2">{{ $review->review_text }}</p>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-gray-400 text-lg">No reviews yet. Be the first to review!</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
