{{-- ============================================ --}}
{{-- resources/views/teams/show.blade.php --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', $team->name)

@section('content')
<div class="bg-gradient-to-r from-pink-600 to-purple-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-6">
            <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center">
                @if($team->logo)
                    <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-full h-full object-cover rounded-full">
                @else
                    <span class="text-6xl">👥</span>
                @endif
            </div>
            <div>
                <h1 class="text-4xl font-bold mb-2">{{ $team->name }}</h1>
                <div class="flex items-center gap-4">
                    <span class="bg-white text-pink-600 px-4 py-1 rounded-full text-sm font-semibold">{{ $team->tag }}</span>
                    <span class="text-lg">Win Rate: {{ number_format($team->win_rate, 1) }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Team Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">About</h2>
                <p class="text-gray-700">{{ $team->description ?: 'No description available.' }}</p>
            </div>

            <!-- Members -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">Team Members ({{ $team->members()->count() }}/{{ $team->max_members }})</h2>
                <div class="space-y-4">
                    @foreach($team->members as $member)
                        <div class="flex items-center justify-between border-b pb-4">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}" 
                                     alt="{{ $member->name }}" 
                                     class="w-12 h-12 rounded-full mr-4">
                                <div>
                                    <p class="font-bold">{{ $member->name }}</p>
                                    <p class="text-sm text-gray-600">{{ ucfirst($member->pivot->role) }}</p>
                                </div>
                            </div>
                            @if($member->id === $team->captain_id)
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs">Captain</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Match History -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Recent Matches</h2>
                <div class="space-y-4">
                    @forelse($matches as $match)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 text-right">
                                    <p class="font-bold {{ $match->winner_id == $match->team1_id ? 'text-green-600' : '' }}">
                                        {{ $match->team1->name }}
                                    </p>
                                </div>
                                <div class="px-6 text-center">
                                    <div class="text-xl font-bold">
                                        <span class="{{ $match->winner_id == $match->team1_id ? 'text-green-600' : 'text-gray-400' }}">
                                            {{ $match->team1_score ?? 0 }}
                                        </span>
                                        <span class="text-gray-400 mx-2">-</span>
                                        <span class="{{ $match->winner_id == $match->team2_id ? 'text-green-600' : 'text-gray-400' }}">
                                            {{ $match->team2_score ?? 0 }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600">{{ $match->tournament->game->title }}</p>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold {{ $match->winner_id == $match->team2_id ? 'text-green-600' : '' }}">
                                        {{ $match->team2->name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">No matches played yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Team Stats -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold mb-4">Statistics</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Matches</span>
                        <span class="font-bold">{{ $team->total_matches }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Win Rate</span>
                        <span class="font-bold text-green-600">{{ number_format($team->win_rate, 1) }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Captain</span>
                        <span class="font-bold">{{ $team->captain->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Members</span>
                        <span class="font-bold">{{ $team->members()->count() }}/{{ $team->max_members }}</span>
                    </div>
                </div>
            </div>

            <!-- Tournaments -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Tournaments</h3>
                <div class="space-y-3">
                    @forelse($team->tournamentRegistrations as $registration)
                        <div class="border-b pb-3">
                            <p class="font-semibold text-sm">{{ $registration->tournament->name }}</p>
                            <p class="text-xs text-gray-600">{{ $registration->tournament->game->title }}</p>
                            <span class="text-xs px-2 py-1 rounded 
                                {{ $registration->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($registration->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No tournament registrations</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
