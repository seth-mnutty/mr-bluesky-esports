@extends('layouts.app')

@section('title', 'Dashboard - MR BLUESKY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Welcome Header -->
        <div class="mb-10">
            <h1 class="text-4xl sm:text-5xl font-black text-white mb-2 uppercase tracking-tight">Welcome back, {{ auth()->user()->name }}</h1>
            <p class="text-gray-400 text-lg">Here's what's happening with your esports journey</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Teams Card -->
            <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl p-8 hover:border-sky-500/60 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-sky-900/30">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wide mb-2">Your Teams</p>
                        <p class="text-5xl font-black text-white mb-1">{{ auth()->user()->teams()->count() }}</p>
                        <p class="text-sm text-gray-500">Active teams</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-sky-600 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg border border-sky-500/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tournaments Card -->
            <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl p-8 hover:border-sky-500/60 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-sky-900/30">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wide mb-2">Tournaments</p>
                        <p class="text-5xl font-black text-white mb-1">
                            {{ $joinedTournamentsCount }}
                        </p>
                        <p class="text-sm text-gray-500">Joined tournaments</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-sky-600 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg border border-sky-500/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Reviews Card -->
            <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl p-8 hover:border-sky-500/60 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-sky-900/30">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wide mb-2">Reviews</p>
                        <p class="text-5xl font-black text-white mb-1">{{ $reviewsCount }}</p>
                        <p class="text-sm text-gray-500">Your reviews</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-sky-600 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg border border-sky-500/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Tournaments -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-black text-white uppercase tracking-tight">Upcoming Tournaments</h2>
                <a href="{{ route('tournaments.index') }}" class="text-sky-500 hover:text-sky-400 font-bold flex items-center gap-1">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            @if($upcomingTournaments->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($upcomingTournaments as $tournament)
                        <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl overflow-hidden hover:border-sky-500/60 transition-all duration-300 group flex flex-col h-full">
                            <!-- Tournament Image/Header -->
                            <div class="h-32 bg-gray-800 relative">
                                @if($tournament->image)
                                    <img src="{{ asset('storage/' . $tournament->image) }}" alt="{{ $tournament->name }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-80 transition-opacity">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-sky-900 to-blue-900 opacity-60">
                                        <span class="text-4xl font-black text-white/20">{{ substr($tournament->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3">
                                    <span class="bg-sky-600 text-white text-xs font-bold px-2 py-1 rounded uppercase">
                                        {{ $tournament->game->title ?? 'Game' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-white mb-2 line-clamp-1" title="{{ $tournament->name }}">{{ $tournament->name }}</h3>
                                <div class="space-y-2 mb-4 flex-1">
                                    <div class="flex items-center text-gray-400 text-sm">
                                        <svg class="w-4 h-4 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }}
                                    </div>
                                    @if($tournament->prize_pool)
                                        <div class="flex items-center text-gray-400 text-sm">
                                            <svg class="w-4 h-4 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Kshs {{ number_format($tournament->prize_pool) }}
                                        </div>
                                    @endif
                                </div>
                                
                                <a href="{{ route('tournaments.show', $tournament->slug) }}" class="block w-full text-center bg-gradient-to-r from-sky-600 to-blue-700 text-white py-2 rounded-lg font-bold hover:from-sky-500 hover:to-blue-600 transition shadow-lg shadow-sky-900/20 border border-sky-500/50">
                                    Join Now
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl p-8 text-center">
                    <p class="text-gray-400">No upcoming tournaments found.</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="mb-10">
            <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                @if(auth()->user()->role === 'player')
                    <a href="{{ route('teams.create') }}" class="bg-gradient-to-br from-gray-900 to-black border-2 border-sky-900/30 rounded-xl p-6 hover:border-sky-500/60 hover:bg-gray-900/80 transition-all duration-300 group transform hover:-translate-y-1 shadow-lg hover:shadow-xl hover:shadow-sky-900/20">
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-sky-600 to-blue-700 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg border border-sky-500/50">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-white group-hover:text-sky-400 transition-colors block">Create Team</span>
                                <span class="text-sm text-gray-400">Start a new team</span>
                            </div>
                        </div>
                    </a>
                @endif

                @if(auth()->user()->role === 'organizer' || auth()->user()->role === 'admin')
                    <a href="{{ route('tournaments.create') }}" class="bg-gradient-to-br from-gray-900 to-black border-2 border-sky-900/30 rounded-xl p-6 hover:border-sky-500/60 hover:bg-gray-900/80 transition-all duration-300 group transform hover:-translate-y-1 shadow-lg hover:shadow-xl hover:shadow-sky-900/20">
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-sky-600 to-blue-700 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg border border-sky-500/50">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div>
                                <span class="font-bold text-white group-hover:text-sky-400 transition-colors block">Create Tournament</span>
                                <span class="text-sm text-gray-400">Organize an event</span>
                            </div>
                        </div>
                    </a>
                @endif

                <a href="{{ route('profile.show') }}" class="bg-gradient-to-br from-gray-900 to-black border-2 border-sky-900/30 rounded-xl p-6 hover:border-sky-500/60 hover:bg-gray-900/80 transition-all duration-300 group transform hover:-translate-y-1 shadow-lg hover:shadow-xl hover:shadow-sky-900/20">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-sky-600 to-blue-700 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg border border-sky-500/50">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-white group-hover:text-sky-400 transition-colors block">View Profile</span>
                            <span class="text-sm text-gray-400">Manage account</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('games.index') }}" class="bg-gradient-to-br from-gray-900 to-black border-2 border-sky-900/30 rounded-xl p-6 hover:border-sky-500/60 hover:bg-gray-900/80 transition-all duration-300 group transform hover:-translate-y-1 shadow-lg hover:shadow-xl hover:shadow-sky-900/20">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-sky-600 to-blue-700 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg border border-sky-500/50">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-white group-hover:text-sky-400 transition-colors block">Browse Games</span>
                            <span class="text-sm text-gray-400">Explore catalog</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-black text-white uppercase tracking-tight">Recent Activity</h2>
                <a href="#" class="text-sm text-sky-500 hover:text-sky-400 font-bold">View All</a>
            </div>
            <div class="text-center py-16">
                <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-sky-900/30">
                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-400 font-medium mb-2">No recent activity</p>
                <p class="text-sm text-gray-500">Your activities will appear here when available</p>
            </div>
        </div>
    </div>
</div>
@endsection
