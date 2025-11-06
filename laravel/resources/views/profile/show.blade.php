@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black">
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-4xl mx-auto">
            <!-- Profile Header -->
            <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8 mb-6">
                <div class="flex items-center space-x-6 mb-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-sky-700 to-blue-800 rounded-xl flex items-center justify-center border-4 border-sky-600/50 shadow-lg">
                        <span class="text-white text-4xl font-black">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-3xl sm:text-4xl font-black text-white mb-2 uppercase tracking-tight">{{ $user->name }}</h1>
                        <p class="text-gray-400 text-lg">{{ $user->email }}</p>
                        @if($user->role)
                            <span class="inline-block mt-2 bg-sky-600/20 text-sky-400 px-4 py-1 rounded-full text-sm font-bold border border-sky-500/50 uppercase">
                                {{ ucfirst($user->role) }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('profile.edit') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-6 py-2.5 rounded-lg hover:from-sky-500 hover:to-blue-600 transition font-bold border border-sky-500/50">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8 mb-6">
                <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Profile Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-400 mb-2 uppercase text-xs tracking-wider">Email Address</p>
                        <p class="font-bold text-white text-lg">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400 mb-2 uppercase text-xs tracking-wider">Role</p>
                        <span class="inline-block bg-sky-600/20 text-sky-400 px-3 py-1 rounded-full text-sm font-bold border border-sky-500/50 uppercase">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    @if($user->email_verified_at)
                        <div>
                            <p class="text-sm text-gray-400 mb-2 uppercase text-xs tracking-wider">Email Verified</p>
                            <p class="font-bold text-green-400 text-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Verified on {{ $user->email_verified_at->format('M d, Y') }}
                            </p>
                        </div>
                    @else
                        <div>
                            <p class="text-sm text-gray-400 mb-2 uppercase text-xs tracking-wider">Email Verified</p>
                            <p class="font-bold text-yellow-400 text-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Not Verified
                            </p>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-400 mb-2 uppercase text-xs tracking-wider">Member Since</p>
                        <p class="font-bold text-white text-lg">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- User Statistics -->
            @if($user->role === 'player')
                @php
                    $userTeams = \App\Models\Team::whereHas('members', function($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })->count();
                    $userTournaments = \App\Models\TournamentRegistration::whereHas('team.members', function($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })->count();
                @endphp
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8 mb-6">
                    <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Player Statistics</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-800 rounded-xl p-6 border border-sky-900/30">
                            <div class="text-4xl font-black text-sky-500 mb-2">{{ $userTeams }}</div>
                            <div class="text-sm text-gray-400 uppercase tracking-wider">Teams</div>
                        </div>
                        <div class="bg-gray-800 rounded-xl p-6 border border-sky-900/30">
                            <div class="text-4xl font-black text-sky-500 mb-2">{{ $userTournaments }}</div>
                            <div class="text-sm text-gray-400 uppercase tracking-wider">Tournaments</div>
                        </div>
                        <div class="bg-gray-800 rounded-xl p-6 border border-sky-900/30">
                            <div class="text-4xl font-black text-sky-500 mb-2">
                                @php
                                    $totalMatches = \App\Models\Matches::whereHas('team1.members', function($query) use ($user) {
                                        $query->where('user_id', $user->id);
                                    })->orWhereHas('team2.members', function($query) use ($user) {
                                        $query->where('user_id', $user->id);
                                    })->where('status', 'completed')->count();
                                @endphp
                                {{ $totalMatches }}
                            </div>
                            <div class="text-sm text-gray-400 uppercase tracking-wider">Matches Played</div>
                        </div>
                    </div>
                </div>
            @elseif($user->role === 'organizer')
                @php
                    $organizedTournaments = \App\Models\Tournament::where('organizer_id', $user->id)->count();
                @endphp
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8 mb-6">
                    <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Organizer Statistics</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-800 rounded-xl p-6 border border-sky-900/30">
                            <div class="text-4xl font-black text-sky-500 mb-2">{{ $organizedTournaments }}</div>
                            <div class="text-sm text-gray-400 uppercase tracking-wider">Tournaments Organized</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('profile.edit') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-6 py-4 rounded-xl hover:from-sky-500 hover:to-blue-600 transition font-bold border border-sky-500/50 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Edit Profile</span>
                    </a>
                    @if($user->role === 'player')
                        <a href="{{ route('teams.create') }}" class="bg-gray-800 text-gray-300 px-6 py-4 rounded-xl hover:bg-gray-700 transition font-bold border border-sky-900/30 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Create Team</span>
                        </a>
                    @elseif($user->role === 'organizer')
                        <a href="{{ route('tournaments.create') }}" class="bg-gray-800 text-gray-300 px-6 py-4 rounded-xl hover:bg-gray-700 transition font-bold border border-sky-900/30 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Create Tournament</span>
                        </a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="bg-gray-800 text-gray-300 px-6 py-4 rounded-xl hover:bg-gray-700 transition font-bold border border-sky-900/30 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('tournaments.index') }}" class="bg-gray-800 text-gray-300 px-6 py-4 rounded-xl hover:bg-gray-700 transition font-bold border border-sky-900/30 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Browse Tournaments</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

