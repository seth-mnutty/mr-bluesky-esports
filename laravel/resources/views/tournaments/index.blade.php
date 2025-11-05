@extends('layouts.app')

@section('title', 'Tournaments - BLUESKY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl sm:text-5xl font-black text-white mb-2 uppercase tracking-tight">BLUESKY Tournaments</h1>
                <p class="text-gray-400 text-lg">Browse and join competitive tournaments</p>
            </div>
            @auth
                @if(auth()->user()->role === 'organizer' || auth()->user()->role === 'admin')
                    <a href="{{ route('tournaments.create') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-sky-500 hover:to-blue-600 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-bold border border-sky-500/50">
                        Create Tournament
                    </a>
                @endif
            @endauth
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tournaments as $tournament)
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-xl overflow-hidden hover:border-sky-500/60 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-sky-900/30">
                    <div class="h-40 bg-gradient-to-br from-sky-900/40 to-blue-900/20 flex items-center justify-center relative overflow-hidden">
                        @php
                            $bannerImage = null;
                            if($tournament->banner_image) {
                                $bannerImage = asset('storage/' . $tournament->banner_image);
                            } elseif($tournament->game && $tournament->game->cover_image) {
                                $bannerImage = filter_var($tournament->game->cover_image, FILTER_VALIDATE_URL) 
                                    ? $tournament->game->cover_image 
                                    : asset('storage/' . $tournament->game->cover_image);
                            }
                        @endphp
                        @if($bannerImage)
                            <img src="{{ $bannerImage }}" alt="{{ $tournament->name }}" class="w-full h-full object-cover opacity-90" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden text-sky-400 text-4xl font-black">{{ substr($tournament->name, 0, 1) }}</div>
                        @else
                            <div class="text-sky-400 text-4xl font-black">{{ substr($tournament->name, 0, 1) }}</div>
                        @endif
                        <span class="absolute top-3 right-3 bg-gradient-to-r from-sky-600 to-blue-700 text-white text-xs px-3 py-1 rounded-full font-bold border border-sky-500/50 shadow-lg uppercase">
                            {{ str_replace('_', ' ', ucfirst($tournament->status)) }}
                        </span>
                    </div>
                    <div class="p-6 bg-gradient-to-b from-gray-900 to-black">
                        <h3 class="font-bold text-xl text-white mb-2 line-clamp-1">{{ $tournament->name }}</h3>
                        <p class="text-sm text-gray-400 mb-4">{{ $tournament->game->title }}</p>
                        <div class="space-y-2 text-sm text-gray-400 mb-5">
                            @if($tournament->tournament_start)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $tournament->tournament_start->format('M d, Y') }}</span>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span>{{ $tournament->max_teams }} Teams</span>
                            </div>
                            @if($tournament->prize_pool)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-bold text-sky-500">Kshs {{ number_format($tournament->prize_pool, 0) }}</span>
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('tournaments.show', $tournament->slug) }}" class="block w-full text-center bg-gradient-to-r from-sky-600 to-blue-700 text-white py-2.5 rounded-lg hover:from-sky-500 hover:to-blue-600 transition font-bold text-sm border border-sky-500/50">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20">
                    <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-sky-900/30">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 text-lg font-medium mb-2">No tournaments available</p>
                    <p class="text-gray-500 text-sm">Check back later for new tournaments</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-10">
            {{ $tournaments->links() }}
        </div>
    </div>
</div>
@endsection
