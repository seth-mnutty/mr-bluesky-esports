{{-- ============================================ --}}
{{-- resources/views/tournaments/show.blade.php --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', $tournament->name)

@section('content')
<div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h1 class="text-4xl font-bold mb-2">{{ $tournament->name }}</h1>
                <p class="text-xl mb-4">{{ $tournament->game->title }}</p>
                <div class="flex items-center gap-4">
                    <span class="bg-white text-purple-600 px-4 py-1 rounded-full text-sm font-semibold">
                        {{ str_replace('_', ' ', ucfirst($tournament->status)) }}
                    </span>
                    <span class="bg-white bg-opacity-20 px-4 py-1 rounded-full text-sm">
                        {{ $tournament->format }}
                    </span>
                </div>
            </div>
            @if($tournament->prize_pool)
                <div class="text-right">
                    <p class="text-sm opacity-80">Prize Pool</p>
                    <p class="text-3xl font-bold">Kshs {{ number_format($tournament->prize_pool, 0) }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Tournament Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">Tournament Details</h2>
                <p class="text-gray-700 mb-6">{{ $tournament->description }}</p>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Registration Start</p>
                        <p class="font-semibold">{{ $tournament->registration_start->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Registration End</p>
                        <p class="font-semibold">{{ $tournament->registration_end->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Tournament Start</p>
                        <p class="font-semibold">{{ $tournament->tournament_start->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Max Teams</p>
                        <p class="font-semibold">{{ $tournament->max_teams }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Team Size</p>
                        <p class="font-semibold">{{ $tournament->team_size }} players</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Organizer</p>
                        <p class="font-semibold">{{ $tournament->organizer->name }}</p>
                    </div>
                </div>

                @if($tournament->rules)
                    <div class="mt-6">
                        <h3 class="font-bold mb-2">Rules</h3>
                        <ul class="list-disc list-inside text-gray-700">
                            @foreach($tournament->rules as $rule)
                                <li>{{ $rule }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Registered Teams -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">Registered Teams ({{ $registeredTeams->count() }}/{{ $tournament->max_teams }})</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($registeredTeams as $registration)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-bold">{{ $registration->team->name }}</h4>
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $registration->team->tag }}</span>
                            </div>
                            <p class="text-sm text-gray-600">Captain: {{ $registration->team->captain->name }}</p>
                            <a href="{{ route('teams.show', $registration->team->slug) }}" class="text-sm text-indigo-600 hover:underline">
                                View Team →
                            </a>
                        </div>
                    @empty
                        <p class="col-span-2 text-center text-gray-500 py-8">No teams registered yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Matches -->
            @if($upcomingMatches->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4">Upcoming Matches</h2>
                    <div class="space-y-4">
                        @foreach($upcomingMatches as $match)
                            <div class="border rounded-lg p-4 flex items-center justify-between">
                                <div class="flex-1 text-right">
                                    <p class="font-bold">{{ $match->team1->name }}</p>
                                </div>
                                <div class="px-6 text-center">
                                    <p class="text-2xl font-bold text-gray-400">VS</p>
                                    <p class="text-xs text-gray-600">{{ $match->scheduled_at->format('M d, g:i A') }}</p>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold">{{ $match->team2->name }}</p>
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
            @if($userCanRegister)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-xl font-bold mb-4">Register Your Team</h3>
                    <form action="{{ route('tournaments.register', $tournament->slug) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Select Team</label>
                            <select name="team_id" class="w-full border rounded-lg px-4 py-2" required>
                                <option value="">Choose a team</option>
                                @foreach(auth()->user()->captainedTeams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                            Register Team
                        </button>
                    </form>
                </div>
            @endif

            <!-- Tournament Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Statistics</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Registered Teams</span>
                        <span class="font-bold">{{ $registeredTeams->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Available Slots</span>
                        <span class="font-bold">{{ $tournament->max_teams - $registeredTeams->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Matches</span>
                        <span class="font-bold">{{ $tournament->matches()->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
