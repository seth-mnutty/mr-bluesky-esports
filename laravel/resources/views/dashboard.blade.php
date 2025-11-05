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
                            @php
                                $teamIds = auth()->user()->teams()->pluck('teams.id')->merge(auth()->user()->captainedTeams()->pluck('id'));
                                $tournamentCount = \App\Models\TournamentRegistration::whereIn('team_id', $teamIds)->count();
                            @endphp
                            {{ $tournamentCount }}
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
                        <p class="text-5xl font-black text-white mb-1">{{ auth()->user()->gameReviews()->count() }}</p>
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
