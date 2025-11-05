@extends('layouts.app')

@section('title', 'Games - BLUESKY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl sm:text-5xl font-black text-white mb-2 uppercase tracking-tight">BLUESKY Games</h1>
                <p class="text-gray-400 text-lg">Browse and discover esports games</p>
            </div>
            @auth
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'organizer')
                    <a href="{{ route('games.create') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-sky-500 hover:to-blue-600 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-bold border border-sky-500/50">
                        Add New Game
                    </a>
                @endif
            @endauth
        </div>

        <!-- Games Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($games as $game)
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl overflow-hidden hover:border-sky-500/60 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-sky-900/50">
                    <div class="h-56 bg-gradient-to-br from-sky-900/40 to-blue-900/20 flex items-center justify-center relative overflow-hidden">
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
                            <div class="hidden text-sky-400 text-4xl font-black">{{ substr($game->title, 0, 1) }}</div>
                        @else
                            <div class="text-sky-400 text-4xl font-black">{{ substr($game->title, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="p-6 bg-gradient-to-b from-gray-900 to-black">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-bold text-lg text-white line-clamp-1 pr-2">{{ $game->title }}</h3>
                            <span class="text-xs text-sky-400 bg-sky-900/30 px-2 py-1 rounded-full whitespace-nowrap border border-sky-800/50 uppercase">{{ $game->genre }}</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-4 line-clamp-2 h-10">{{ Str::limit($game->description ?? '', 60) }}</p>
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center">
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($game->average_rating ?? 0))
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 fill-current text-gray-700" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm text-gray-400">{{ number_format($game->average_rating ?? 0, 1) }}</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-800 px-2 py-1 rounded border border-gray-700">{{ $game->platform }}</span>
                        </div>
                        <a href="{{ route('games.show', $game->slug) }}" class="block w-full text-center bg-gradient-to-r from-sky-600 to-blue-700 text-white py-2.5 rounded-xl hover:from-sky-500 hover:to-blue-600 transition font-bold text-sm border border-sky-500/50">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-20">
                    <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-sky-900/30">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 text-lg font-medium mb-2">No games available yet</p>
                    <p class="text-gray-500 text-sm">Check back later for new games</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-10">
            {{ $games->links() }}
        </div>
    </div>
</div>
@endsection
