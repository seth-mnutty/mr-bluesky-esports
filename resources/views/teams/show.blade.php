@extends('layouts.app')

@section('title', $team->name . ' - Team Details - BLUESKY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black">
    <!-- Team Header -->
    <div class="bg-gradient-to-r from-sky-900 via-blue-900 to-sky-800 text-white py-16 border-b border-sky-900/30">
        <div class="container mx-auto px-4">
            <div class="flex items-start justify-between flex-wrap gap-6">
                <div class="flex items-center space-x-6 flex-1">
                    <div class="w-24 h-24 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border-4 border-white/20">
                        @if($team->logo)
                            <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            <span class="text-white text-4xl font-black">{{ substr($team->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h1 class="text-4xl sm:text-5xl font-black mb-2 uppercase tracking-tight">{{ $team->name }}</h1>
                        <p class="text-xl mb-4 text-gray-300">[{{ $team->tag }}]</p>
                        @if($team->description)
                            <p class="text-gray-300 max-w-2xl">{{ Str::limit($team->description, 150) }}</p>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    @if($team->win_rate)
                        <p class="text-sm opacity-80 mb-1 uppercase tracking-wider">Win Rate</p>
                        <p class="text-4xl font-black">{{ number_format($team->win_rate, 1) }}%</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Team Info -->
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Team Information</h2>
                    @if($team->description)
                        <p class="text-gray-300 mb-6 leading-relaxed text-lg">{{ $team->description }}</p>
                    @endif
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-400 mb-2 uppercase text-xs tracking-wider">Captain</p>
                            <p class="font-bold text-white text-lg">{{ $team->captain->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400 mb-2 uppercase text-xs tracking-wider">Members</p>
                            <p class="font-bold text-white text-lg">{{ $team->members()->count() }} / {{ $team->max_members }}</p>
                        </div>
                        @if($team->total_matches)
                            <div>
                                <p class="text-sm text-gray-400 mb-2 uppercase text-xs tracking-wider">Total Matches</p>
                                <p class="font-bold text-white text-lg">{{ $team->total_matches }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-400 mb-2 uppercase text-xs tracking-wider">Status</p>
                            <span class="inline-block bg-green-900/50 text-green-400 px-3 py-1 rounded-full text-sm font-bold border border-green-800/50">
                                {{ $team->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Team Members -->
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Team Members</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($team->members as $member)
                            <div class="flex items-center space-x-4 p-4 bg-gray-900/50 rounded-xl hover:bg-gray-800/50 transition-colors border border-sky-900/30">
                                <div class="w-12 h-12 bg-gradient-to-br from-sky-600 to-blue-700 rounded-xl flex items-center justify-center border border-sky-500/50">
                                    <span class="text-white font-bold text-sm">{{ substr($member->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-white">
                                        {{ $member->name }}
                                        @if($member->id === $team->captain_id)
                                            <span class="text-xs bg-sky-900/50 text-sky-400 px-2 py-0.5 rounded ml-2 border border-sky-800/50 font-bold uppercase">Captain</span>
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-400">{{ ucfirst($member->pivot->role ?? 'player') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8">
                                <p class="text-gray-500 text-lg">No members yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tournament Registrations -->
                @if($team->tournamentRegistrations->count() > 0)
                    <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Tournament Registrations</h2>
                        <div class="space-y-4">
                            @foreach($team->tournamentRegistrations as $registration)
                                <div class="border border-sky-900/30 rounded-xl p-5 hover:border-sky-500/60 transition-all bg-gray-900/50">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="font-bold text-lg text-white mb-1">{{ $registration->tournament->name }}</h3>
                                            <p class="text-sm text-gray-400 mb-2">{{ $registration->tournament->game->title }}</p>
                                            <div class="flex items-center gap-4 text-sm">
                                                <span class="inline-block bg-sky-900/50 text-sky-400 px-2 py-1 rounded text-xs font-bold border border-sky-800/50 uppercase">
                                                    {{ ucfirst($registration->tournament->status) }}
                                                </span>
                                                @if($registration->tournament->prize_pool)
                                                    <span class="font-bold text-sky-500">Kshs {{ number_format($registration->tournament->prize_pool, 0) }} Prize Pool</span>
                                                @endif
                                            </div>
                                        </div>
                                        <a href="{{ route('tournaments.show', $registration->tournament->slug) }}" class="text-sky-500 hover:text-sky-400 font-bold text-sm flex items-center space-x-1 group">
                                            <span>View Tournament</span>
                                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Team Matches -->
                @if($matches->count() > 0)
                    <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl sm:text-3xl font-black text-white mb-6 uppercase tracking-tight">Recent Matches</h2>
                        <div class="space-y-4">
                            @foreach($matches as $match)
                                <div class="border border-sky-900/30 rounded-xl p-5 hover:border-sky-500/60 transition-all bg-gray-900/50">
                                    <div class="flex items-center justify-between flex-wrap gap-4">
                                        <div class="flex-1 text-right min-w-[120px]">
                                            <h4 class="font-bold text-lg text-white">{{ $match->team1->name }}</h4>
                                            <span class="text-sm text-gray-400">{{ $match->team1->tag }}</span>
                                        </div>
                                        <div class="text-center px-6">
                                            @if($match->status === 'completed' && $match->team1_score !== null && $match->team2_score !== null)
                                                <div class="bg-gradient-to-br from-sky-900/40 to-blue-900/20 rounded-xl px-6 py-3 mb-2 border border-sky-800/50">
                                                    <span class="text-2xl font-black text-white">{{ $match->team1_score }}</span>
                                                    <span class="text-xl font-bold text-gray-400 mx-2">-</span>
                                                    <span class="text-2xl font-black text-white">{{ $match->team2_score }}</span>
                                                </div>
                                                @if($match->winner)
                                                    <p class="text-xs text-gray-400">
                                                        Winner: <span class="font-bold text-sky-400">{{ $match->winner->name }}</span>
                                                    </p>
                                                @endif
                                            @else
                                                <div class="bg-gradient-to-br from-sky-900/40 to-blue-900/20 rounded-xl px-6 py-3 mb-2 border border-sky-800/50">
                                                    <span class="text-xl font-black text-sky-400">VS</span>
                                                </div>
                                            @endif
                                            <div class="text-sm font-medium text-gray-300 mt-2">
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
                                            @php
                                                $statusColors = [
                                                    'completed' => 'bg-green-900/50 text-green-400 border-green-800/50',
                                                    'live' => 'bg-red-900/50 text-red-400 border-red-800/50',
                                                    'scheduled' => 'bg-sky-900/50 text-sky-400 border-sky-800/50',
                                                    'cancelled' => 'bg-gray-800 text-gray-400 border-gray-700'
                                                ];
                                                $statusColor = $statusColors[$match->status] ?? 'bg-gray-800 text-gray-400 border-gray-700';
                                            @endphp
                                            <span class="inline-block {{ $statusColor }} px-3 py-1 rounded-full text-xs font-bold border uppercase">
                                                {{ ucfirst($match->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-sky-900/30">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-gray-400 font-medium mb-2">No matches yet</p>
                            <p class="text-sm text-gray-500">Matches will appear here when scheduled</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Team Stats -->
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-6 mb-6 sticky top-6">
                    <h3 class="text-xl font-black text-white mb-6 uppercase tracking-tight">Team Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-sky-900/30">
                            <span class="text-gray-400 uppercase text-xs tracking-wider">Win Rate</span>
                            <span class="font-black text-white text-xl">{{ $team->win_rate ? number_format($team->win_rate, 1) : '0' }}%</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-sky-900/30">
                            <span class="text-gray-400 uppercase text-xs tracking-wider">Total Matches</span>
                            <span class="font-black text-white text-xl">{{ $team->total_matches ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-sky-900/30">
                            <span class="text-gray-400 uppercase text-xs tracking-wider">Members</span>
                            <span class="font-black text-white text-xl">{{ $team->members()->count() }}/{{ $team->max_members }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 uppercase text-xs tracking-wider">Tournaments</span>
                            <span class="font-black text-white text-xl">{{ $team->tournamentRegistrations->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @auth
                    @if(auth()->id() === $team->captain_id)
                        <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-6">
                            <h3 class="text-xl font-black text-white mb-4 uppercase tracking-tight">Team Management</h3>
                            <div class="space-y-3">
                                <a href="{{ route('teams.edit', $team->slug) }}" class="block w-full text-center bg-gradient-to-r from-sky-600 to-blue-700 text-white py-2.5 rounded-xl hover:from-sky-500 hover:to-blue-600 transition font-bold border border-sky-500/50">
                                    Edit Team
                                </a>
                                <a href="{{ route('teams.members', $team->slug) }}" class="block w-full text-center bg-gray-800 border border-sky-900/30 text-gray-300 py-2.5 rounded-xl hover:bg-gray-700 transition font-bold">
                                    Manage Members
                                </a>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
