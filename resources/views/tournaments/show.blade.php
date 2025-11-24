@extends('layouts.app')

@section('title', $tournament->name . ' - BLUESKY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black">
    <!-- Tournament Header -->
    <div class="bg-gradient-to-r from-sky-900 via-blue-900 to-sky-800 text-white py-16 border-b border-sky-900/30">
        <div class="container mx-auto px-4">
            <div class="flex items-start justify-between flex-wrap gap-6">
                <div class="flex-1">
                    <h1 class="text-4xl sm:text-5xl font-black mb-2 uppercase tracking-tight">{{ $tournament->name }}</h1>
                    <p class="text-xl mb-4 text-gray-300">{{ $tournament->game->title }}</p>
                    <div class="flex items-center gap-4">
                        <span class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-4 py-1 rounded-full text-sm font-bold border border-sky-500/50">
                            {{ str_replace('_', ' ', ucfirst($tournament->status)) }}
                        </span>
                        <span class="bg-white/10 backdrop-blur-sm px-4 py-1 rounded-full text-sm border border-white/20">
                            {{ $tournament->format }}
                        </span>
                    </div>
                </div>
                @if($tournament->prize_pool)
                    <div class="text-right">
                        <p class="text-sm opacity-80 mb-1 uppercase tracking-wider">Prize Pool</p>
                        <p class="text-4xl font-black">Kshs {{ number_format($tournament->prize_pool, 0) }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Tournament Info -->
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Tournament Details</h2>
                    <p class="text-gray-300 mb-8 leading-relaxed text-lg">{{ $tournament->description }}</p>
                    
                    <div class="grid grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="text-gray-400 mb-2 uppercase text-xs tracking-wider">Tournament Start</p>
                            <p class="font-bold text-white text-lg">
                                @if($tournament->tournament_start)
                                    {{ $tournament->tournament_start->format('M d, Y') }}
                                @else
                                    <span class="text-gray-500">Not set</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-400 mb-2 uppercase text-xs tracking-wider">Tournament End</p>
                            <p class="font-bold text-white text-lg">
                                @if($tournament->tournament_end)
                                    {{ $tournament->tournament_end->format('M d, Y') }}
                                @else
                                    <span class="text-gray-500">Not set</span>
                                @endif
                            </p>
                        </div>
                        @if($tournament->registration_start)
                            <div>
                                <p class="text-gray-400 mb-2 uppercase text-xs tracking-wider">Registration Start</p>
                                <p class="font-bold text-white text-lg">{{ $tournament->registration_start->format('M d, Y') }}</p>
                            </div>
                        @endif
                        @if($tournament->registration_end)
                            <div>
                                <p class="text-gray-400 mb-2 uppercase text-xs tracking-wider">Registration End</p>
                                <p class="font-bold text-white text-lg">{{ $tournament->registration_end->format('M d, Y') }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-gray-400 mb-2 uppercase text-xs tracking-wider">Max Teams</p>
                            <p class="font-bold text-white text-lg">{{ $tournament->max_teams }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 mb-2 uppercase text-xs tracking-wider">Organizer</p>
                            <p class="font-bold text-white text-lg">{{ $tournament->organizer->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Registered Teams -->
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Registered Teams ({{ $registeredTeams->count() }}/{{ $tournament->max_teams }})</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($registeredTeams as $registration)
                            <div class="border border-sky-900/30 rounded-xl p-5 hover:border-sky-500/60 transition-all bg-gray-900/50">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-bold text-white">{{ $registration->team->name }}</h4>
                                    <span class="bg-sky-900/50 text-sky-400 text-xs px-3 py-1 rounded-full border border-sky-800/50 font-bold uppercase">{{ $registration->team->tag }}</span>
                                </div>
                                <p class="text-sm text-gray-400 mb-3">Captain: <span class="text-white font-semibold">{{ $registration->team->captain->name }}</span></p>
                                <a href="{{ route('teams.show', $registration->team->slug) }}" class="text-sm text-sky-500 hover:text-sky-400 font-bold flex items-center space-x-1 group">
                                    <span>View Team</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-12">
                                <p class="text-gray-500 text-lg">No teams registered yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Upcoming Matches -->
                @if($upcomingMatches->count() > 0)
                    <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Upcoming Matches</h2>
                        <div class="space-y-4">
                            @foreach($upcomingMatches as $match)
                                <div class="border border-sky-900/30 rounded-xl p-5 flex items-center justify-between hover:border-sky-500/60 transition-all bg-gray-900/50">
                                    <div class="flex-1 text-right">
                                        <p class="font-bold text-white text-lg">{{ $match->team1->name }}</p>
                                        <span class="text-sm text-gray-400">{{ $match->team1->tag }}</span>
                                    </div>
                                    <div class="px-6 text-center">
                                        <div class="bg-gradient-to-br from-sky-900/40 to-blue-900/20 rounded-xl px-6 py-3 mb-2 border border-sky-800/50">
                                            <span class="text-2xl font-black text-sky-400">VS</span>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">
                                            @if($match->scheduled_at)
                                                {{ $match->scheduled_at->format('M d, g:i A') }}
                                            @else
                                                <span class="text-gray-500">TBD</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-white text-lg">{{ $match->team2->name }}</p>
                                        <span class="text-sm text-gray-400">{{ $match->team2->tag }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Registration -->
                <!-- Registration -->
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-6 mb-6">
                    <h3 class="text-xl font-black text-white mb-4 uppercase tracking-tight">Register Your Team</h3>
                    
                    @auth
                        @if($tournament->isRegistrationOpen())
                            @if($registeredTeams->count() >= $tournament->max_teams)
                                <div class="bg-red-500/10 border border-red-500/50 rounded-lg p-4 text-center">
                                    <p class="text-red-400 font-bold">Tournament is Full</p>
                                </div>
                            @elseif(auth()->user()->captainedTeams->count() > 0)
                                <form action="{{ route('tournaments.register', $tournament->slug) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-bold mb-2 text-gray-300 uppercase text-xs tracking-wider">Select Team</label>
                                        <select name="team_id" class="w-full bg-gray-900 border border-sky-900/30 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500" required>
                                            <option value="">Choose a team</option>
                                            @foreach(auth()->user()->captainedTeams as $team)
                                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full bg-gradient-to-r from-sky-600 to-blue-700 text-white py-3 rounded-lg hover:from-sky-500 hover:to-blue-600 transition font-bold border border-sky-500/50">
                                        Register Team
                                    </button>
                                </form>
                            @else
                                <div class="text-center">
                                    <p class="text-gray-400 mb-4">You need to be a team captain to register.</p>
                                    <a href="{{ route('teams.create') }}" class="block w-full bg-gradient-to-r from-sky-600 to-blue-700 text-white py-3 rounded-lg hover:from-sky-500 hover:to-blue-600 transition font-bold border border-sky-500/50">
                                        Create a Team
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="bg-yellow-500/10 border border-yellow-500/50 rounded-lg p-4 text-center">
                                <p class="text-yellow-400 font-bold">Registration is currently closed</p>
                                <p class="text-sm text-gray-400 mt-1">
                                    @if($tournament->registration_start > now())
                                        Opens: {{ $tournament->registration_start->format('M d, Y') }}
                                    @else
                                        Closed: {{ $tournament->registration_end->format('M d, Y') }}
                                    @endif
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="text-center">
                            <p class="text-gray-400 mb-4">Please login to register for this tournament.</p>
                            <a href="{{ route('login') }}" class="block w-full bg-gradient-to-r from-sky-600 to-blue-700 text-white py-3 rounded-lg hover:from-sky-500 hover:to-blue-600 transition font-bold border border-sky-500/50">
                                Login to Register
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Tournament Stats -->
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-6 sticky top-6">
                    <h3 class="text-xl font-black text-white mb-6 uppercase tracking-tight">Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-sky-900/30">
                            <span class="text-gray-400 uppercase text-xs tracking-wider">Registered Teams</span>
                            <span class="font-black text-white text-xl">{{ $registeredTeams->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-sky-900/30">
                            <span class="text-gray-400 uppercase text-xs tracking-wider">Available Slots</span>
                            <span class="font-black text-white text-xl">{{ max(0, $tournament->max_teams - $registeredTeams->count()) }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-sky-900/30">
                            <span class="text-gray-400 uppercase text-xs tracking-wider">Total Matches</span>
                            <span class="font-black text-white text-xl">{{ $tournament->matches()->count() }}</span>
                        </div>
                        
                        <a href="{{ route('tournaments.leaderboard', $tournament->slug) }}" class="block w-full bg-gray-800 hover:bg-gray-700 text-white text-center py-3 rounded-lg transition font-bold border border-gray-700">
                            View Leaderboard
                        </a>

                        @can('update', $tournament)
                            <div class="pt-4 border-t border-sky-900/30">
                                <h4 class="text-white font-bold mb-2">Admin Controls</h4>
                                <form action="{{ route('tournaments.generate-fixtures', $tournament->slug) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-700 text-white py-3 rounded-lg hover:from-purple-500 hover:to-indigo-600 transition font-bold border border-purple-500/50" onclick="return confirm('Are you sure you want to generate fixtures? This will create matches for all registered teams.')">
                                        Generate Fixtures
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
