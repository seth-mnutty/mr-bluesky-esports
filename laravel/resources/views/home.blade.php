@extends('layouts.app')

@section('title', 'Home - MR BLUESKY')

@section('content')
<!-- Hero Section -->
<div class="relative bg-black text-white overflow-hidden min-h-screen flex items-center">
    <!-- Animated Background Effect -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-sky-900/20 via-blue-900/10 to-black"></div>
        <!-- Shattered blue fragments effect -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-20 left-10 w-32 h-32 bg-sky-600/20 rotate-45 blur-2xl"></div>
            <div class="absolute top-40 right-20 w-24 h-24 bg-blue-600/20 rotate-12 blur-xl"></div>
            <div class="absolute bottom-32 left-1/4 w-40 h-40 bg-sky-700/15 -rotate-45 blur-3xl"></div>
            <div class="absolute bottom-20 right-1/3 w-28 h-28 bg-blue-500/20 rotate-90 blur-2xl"></div>
            <div class="absolute top-1/2 left-1/2 w-36 h-36 bg-sky-600/10 -rotate-12 blur-3xl"></div>
        </div>
    </div>
    
    <div class="relative container mx-auto px-4 py-20 sm:py-32 z-10">
        <div class="text-center max-w-5xl mx-auto">
            <!-- Event Dates Banner -->
            <div class="mb-8 inline-block">
                <div class="bg-gray-900/80 backdrop-blur-sm border border-sky-900/50 rounded-lg px-6 py-2">
                    <span class="text-white text-sm font-medium tracking-wider uppercase">{{ now()->format('d M') }} - {{ now()->addMonths(2)->format('d M Y') }}</span>
                </div>
            </div>
            
            <!-- Main Title -->
            <h1 class="text-6xl sm:text-7xl md:text-8xl font-black mb-6 leading-tight tracking-tight" style="font-family: 'Arial Black', sans-serif; text-shadow: 0 0 30px rgba(56, 189, 248, 0.5);">
                MR BLUESKY
            </h1>
            
            <!-- Subtitle -->
            <p class="text-xl sm:text-2xl mb-12 text-gray-300 font-light max-w-3xl mx-auto">
                NOTHING IS GRANTED. THE ULTIMATE ESPORTS PLATFORM FEATURING THE WORLD'S BEST COMPETITION
            </p>
            
            <!-- Key Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 max-w-4xl mx-auto">
                <div class="bg-gradient-to-br from-sky-900/60 to-blue-900/40 backdrop-blur-sm border border-sky-800/50 rounded-xl p-6 hover:border-sky-500/80 transition-all">
                    <div class="text-4xl md:text-5xl font-black text-white mb-2">{{ \App\Models\User::where('role', 'player')->count() }}+</div>
                    <div class="text-sm text-gray-300 uppercase tracking-wider">Players</div>
                </div>
                <div class="bg-gradient-to-br from-sky-900/60 to-blue-900/40 backdrop-blur-sm border border-sky-800/50 rounded-xl p-6 hover:border-sky-500/80 transition-all">
                    <div class="text-4xl md:text-5xl font-black text-white mb-2">
                        @php
                            $totalPrize = \App\Models\Tournament::sum('prize_pool');
                        @endphp
                        Kshs {{ number_format($totalPrize, 0) }}
                    </div>
                    <div class="text-sm text-gray-300 uppercase tracking-wider">Prize Pool</div>
                </div>
                <div class="bg-gradient-to-br from-sky-900/60 to-blue-900/40 backdrop-blur-sm border border-sky-800/50 rounded-xl p-6 hover:border-sky-500/80 transition-all">
                    <div class="text-4xl md:text-5xl font-black text-white mb-2">{{ \App\Models\Tournament::count() }}</div>
                    <div class="text-sm text-gray-300 uppercase tracking-wider">Tournaments</div>
                </div>
            </div>
            
            <!-- CTA Buttons -->
            <div class="flex justify-center gap-4 flex-wrap">
                @guest
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-10 py-4 rounded-lg font-bold text-lg hover:from-sky-500 hover:to-blue-600 transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1 border border-sky-500/50">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-sky-500 text-white px-10 py-4 rounded-lg font-bold text-lg hover:bg-sky-500/20 transition-all">
                        Sign In
                    </a>
                @else
                    <a href="{{ route('tournaments.index') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-10 py-4 rounded-lg font-bold text-lg hover:from-sky-500 hover:to-blue-600 transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1 border border-sky-500/50">
                        View Tournaments
                    </a>
                    <a href="{{ route('teams.index') }}" class="bg-transparent border-2 border-sky-500 text-white px-10 py-4 rounded-lg font-bold text-lg hover:bg-sky-500/20 transition-all">
                        Browse Teams
                    </a>
                @endguest
            </div>
            
            <!-- Scroll Indicator -->
            <div class="mt-16 animate-bounce">
                <div class="text-center">
                    <p class="text-sm text-gray-400 mb-2 uppercase tracking-wider">Scroll for more</p>
                    <svg class="w-6 h-6 mx-auto text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-gradient-to-b from-black via-gray-900 to-black border-t border-sky-900/30">
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-5xl md:text-6xl font-black text-sky-500 mb-2">{{ \App\Models\Game::count() }}</div>
                <div class="text-gray-400 font-medium text-sm uppercase tracking-wider">Games</div>
            </div>
            <div class="text-center">
                <div class="text-5xl md:text-6xl font-black text-sky-500 mb-2">{{ \App\Models\Tournament::count() }}</div>
                <div class="text-gray-400 font-medium text-sm uppercase tracking-wider">Tournaments</div>
            </div>
            <div class="text-center">
                <div class="text-5xl md:text-6xl font-black text-sky-500 mb-2">{{ \App\Models\Team::count() }}</div>
                <div class="text-gray-400 font-medium text-sm uppercase tracking-wider">Teams</div>
            </div>
            <div class="text-center">
                <div class="text-5xl md:text-6xl font-black text-sky-500 mb-2">{{ \App\Models\User::count() }}</div>
                <div class="text-gray-400 font-medium text-sm uppercase tracking-wider">Players</div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Games Section -->
<div class="bg-gradient-to-b from-gray-900 to-black py-20 border-t border-sky-900/30">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-4xl sm:text-5xl font-black text-white mb-2 uppercase tracking-tight">BLUESKY Games</h2>
                <p class="text-gray-400 text-lg">Discover the most popular esports titles</p>
            </div>
            <a href="{{ route('games.index') }}" class="text-sky-500 hover:text-sky-400 font-bold flex items-center space-x-2 group">
                <span>View All Games</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredGames as $game)
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-xl overflow-hidden hover:border-sky-500/60 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-sky-900/50">
                    <div class="h-64 bg-gradient-to-br from-sky-900/40 to-blue-900/20 flex items-center justify-center relative overflow-hidden">
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
                    <div class="p-6 bg-gradient-to-b from-gray-900 to-black">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-xl font-bold text-white pr-2">{{ $game->title }}</h3>
                            <span class="text-xs text-sky-400 bg-sky-900/30 px-3 py-1 rounded-full border border-sky-800/50 uppercase">{{ $game->genre }}</span>
                        </div>
                        <div class="flex items-center mb-4">
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
                            <span class="ml-2 text-sm text-gray-400">{{ number_format($game->average_rating ?? 0, 1) }} ({{ $game->total_reviews ?? 0 }} reviews)</span>
                        </div>
                        <p class="text-gray-400 text-sm mb-5 line-clamp-2 h-10">{{ Str::limit($game->description ?? '', 100) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="inline-block bg-sky-900/30 text-sky-400 text-xs px-3 py-1 rounded-full font-medium border border-sky-800/50">{{ $game->platform }}</span>
                            <a href="{{ route('games.show', $game->slug) }}" class="text-sky-500 hover:text-sky-400 font-bold text-sm flex items-center space-x-1 group">
                                <span>View Details</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16">
                    <p class="text-gray-500 text-lg">No games available yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Upcoming Tournaments Section -->
<div class="bg-black py-20 border-t border-sky-900/30">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-4xl sm:text-5xl font-black text-white mb-2 uppercase tracking-tight">BLUESKY Tournaments</h2>
                <p class="text-gray-400 text-lg">Join the competition and compete for glory</p>
            </div>
            <a href="{{ route('tournaments.index') }}" class="text-sky-500 hover:text-sky-400 font-bold flex items-center space-x-2 group">
                <span>View All</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($upcomingTournaments as $tournament)
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-xl overflow-hidden hover:border-sky-500/60 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-sky-900/50">
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
                    <div class="p-5 bg-gradient-to-b from-gray-900 to-black">
                        <h3 class="font-bold text-lg text-white mb-2 line-clamp-1">{{ $tournament->name }}</h3>
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
                <div class="col-span-4 text-center py-16">
                    <p class="text-gray-500 text-lg">No upcoming tournaments yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Ongoing Tournaments Section -->
@if(isset($ongoingTournaments) && $ongoingTournaments->count() > 0)
<div class="bg-gradient-to-b from-black via-gray-900 to-black py-20 border-t border-sky-900/30">
    <div class="container mx-auto px-4">
        <div class="mb-12">
            <h2 class="text-4xl sm:text-5xl font-black text-white mb-2 uppercase tracking-tight">LIVE TOURNAMENTS</h2>
            <p class="text-gray-400 text-lg">Tournaments happening right now</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($ongoingTournaments as $tournament)
                <div class="bg-gradient-to-br from-gray-900 to-black border-2 border-red-600/50 rounded-xl overflow-hidden hover:border-red-500 transition-all duration-300 transform hover:-translate-y-1 shadow-xl shadow-red-900/30">
                    <div class="h-32 bg-gradient-to-br from-red-900/40 to-red-800/20 flex items-center justify-center relative overflow-hidden">
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
                            <img src="{{ $bannerImage }}" alt="{{ $tournament->name }}" class="w-full h-full object-cover opacity-70" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden text-red-400 text-3xl font-black">{{ substr($tournament->name, 0, 1) }}</div>
                        @else
                            <div class="text-red-400 text-3xl font-black">{{ substr($tournament->name, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="bg-gradient-to-r from-red-700 to-red-900 text-white px-5 py-3 flex items-center justify-between border-b border-red-600/50">
                        <span class="font-bold flex items-center text-sm">
                            <span class="w-2.5 h-2.5 bg-white rounded-full mr-2 animate-pulse"></span>
                            LIVE NOW
                        </span>
                        <span class="text-xs bg-white/20 px-2 py-1 rounded border border-white/30 uppercase">{{ $tournament->format }}</span>
                    </div>
                    <div class="p-6 bg-gradient-to-b from-gray-900 to-black">
                        <h3 class="font-bold text-xl text-white mb-2">{{ $tournament->name }}</h3>
                        <p class="text-sm text-gray-400 mb-4">{{ $tournament->game->title }}</p>
                        <div class="text-sm text-gray-400 mb-6">
                            <span>Organized by:</span>
                            <span class="font-semibold text-white">{{ $tournament->organizer->name }}</span>
                        </div>
                        <a href="{{ route('tournaments.show', $tournament->slug) }}" class="block w-full text-center bg-gradient-to-r from-red-700 to-red-900 text-white py-2.5 rounded-lg hover:from-red-600 hover:to-red-800 transition font-bold border border-red-600/50">
                            Watch Live
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Upcoming Matches Section -->
@if(isset($upcomingMatches) && $upcomingMatches->count() > 0)
<div class="bg-black py-20 border-t border-sky-900/30">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-4xl sm:text-5xl font-black text-white mb-2 uppercase tracking-tight">Upcoming Matches</h2>
                <p class="text-gray-400 text-lg">Matches scheduled for the near future</p>
            </div>
            <a href="{{ route('matches.index') }}" class="text-sky-500 hover:text-sky-400 font-bold flex items-center space-x-2 group">
                <span>View All</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        
        <div class="space-y-4">
            @foreach($upcomingMatches as $match)
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-xl p-6 hover:border-sky-500/60 transition-all duration-300 hover:shadow-xl hover:shadow-sky-900/30">
                    <div class="flex items-center justify-between flex-wrap gap-6">
                        <div class="flex-1 text-right min-w-[120px]">
                            <h4 class="font-bold text-lg text-white">{{ $match->team1->name }}</h4>
                            <span class="text-sm text-gray-400">{{ $match->team1->tag }}</span>
                        </div>
                        <div class="text-center px-8">
                            <div class="bg-gradient-to-br from-sky-900/40 to-blue-900/20 rounded-xl px-6 py-3 mb-2 border border-sky-800/50">
                                <span class="text-2xl font-black text-sky-500">VS</span>
                            </div>
                            <div class="text-sm font-medium text-gray-300">
                                @if($match->scheduled_at)
                                    {{ $match->scheduled_at->format('M d, g:i A') }}
                                @else
                                    <span class="text-gray-500">TBD</span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $match->tournament->game->title }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-[120px]">
                            <h4 class="font-bold text-lg text-white">{{ $match->team2->name }}</h4>
                            <span class="text-sm text-gray-400">{{ $match->team2->tag }}</span>
                        </div>
                        <div>
                            <a href="{{ route('matches.show', $match->id) }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-6 py-2.5 rounded-lg hover:from-sky-500 hover:to-blue-600 transition font-bold whitespace-nowrap border border-sky-500/50">
                                View Match
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Call to Action Section -->
<div class="bg-gradient-to-b from-black via-gray-900 to-black py-24 border-t border-sky-900/30">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-5xl sm:text-6xl font-black text-white mb-4 uppercase tracking-tight">Ready to Join the Competition?</h2>
        <p class="text-xl sm:text-2xl mb-12 text-gray-400 max-w-3xl mx-auto">Create your team, join tournaments, and compete with the best players</p>
        @guest
            <a href="{{ route('register') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-12 py-5 rounded-lg font-black text-lg hover:from-sky-500 hover:to-blue-600 transition-all shadow-2xl hover:shadow-sky-900/50 transform hover:-translate-y-1 inline-block border border-sky-500/50">
                Sign Up Now
            </a>
        @else
            @if(auth()->user()->role === 'player')
                <a href="{{ route('teams.create') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-12 py-5 rounded-lg font-black text-lg hover:from-sky-500 hover:to-blue-600 transition-all shadow-2xl hover:shadow-sky-900/50 transform hover:-translate-y-1 inline-block border border-sky-500/50">
                    Create Your Team
                </a>
            @elseif(auth()->user()->role === 'organizer')
                <a href="{{ route('tournaments.create') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-12 py-5 rounded-lg font-black text-lg hover:from-sky-500 hover:to-blue-600 transition-all shadow-2xl hover:shadow-sky-900/50 transform hover:-translate-y-1 inline-block border border-sky-500/50">
                    Organize Tournament
                </a>
            @else
                <a href="{{ route('tournaments.index') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-12 py-5 rounded-lg font-black text-lg hover:from-sky-500 hover:to-blue-600 transition-all shadow-2xl hover:shadow-sky-900/50 transform hover:-translate-y-1 inline-block border border-sky-500/50">
                    Browse Tournaments
                </a>
            @endif
        @endguest
    </div>
</div>
@endsection
