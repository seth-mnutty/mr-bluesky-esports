{{-- ============================================ --}}
{{-- resources/views/matches/show.blade.php --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Match Details')

@section('content')
<div class="bg-gradient-to-r from-red-600 to-orange-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-6">
            <p class="text-lg mb-2">{{ $match->tournament->game->title }} - {{ $match->tournament->name }}</p>
            <p class="text-sm opacity-80">Round {{ $match->round }} - Match #{{ $match->match_number }}</p>
        </div>
        
        <div class="flex items-center justify-center gap-8">
            <div class="text-center flex-1">
                <h2 class="text-3xl font-bold mb-2">{{ $match->team1->name }}</h2>
                <p class="text-sm opacity-80">{{ $match->team1->tag }}</p>
            </div>
            
            <div class="text-center">
                @if($match->status === 'completed')
                    <div class="flex items-center gap-4">
                        <span class="text-5xl font-bold {{ $match->winner_id == $match->team1_id ? 'text-green-300' : 'text-white opacity-50' }}">
                            {{ $match->team1_score }}
                        </span>
                        <span class="text-3xl">-</span>
                        <span class="text-5xl font-bold {{ $match->winner_id == $match->team2_id ? 'text-green-300' : 'text-white opacity-50' }}">
                            {{ $match->team2_score }}
                        </span>
                    </div>
                @elseif($match->status === 'live')
                    <div class="bg-white bg-opacity-20 px-6 py-3 rounded-lg">
                        <span class="text-2xl font-bold flex items-center gap-2">
                            <span class="w-3 h-3 bg-red-300 rounded-full animate-pulse"></span>
                            LIVE
                        </span>
                    </div>
                @else
                    <div class="bg-white bg-opacity-20 px-6 py-3 rounded-lg">
                        <span class="text-2xl font-bold">VS</span>
                    </div>
                @endif
                <p class="text-sm mt-2">{{ $match->scheduled_at->format('M d, Y - g:i A') }}</p>
            </div>
            
            <div class="text-center flex-1">
                <h2 class="text-3xl font-bold mb-2">{{ $match->team2->name }}</h2>
                <p class="text-sm opacity-80">{{ $match->team2->tag }}</p>
            </div>
        </div>

        @if($match->status === 'completed' && $match->winner)
            <div class="text-center mt-6">
                <p class="text-xl">Winner: <span class="font-bold text-green-300">{{ $match->winner->name }}</span></p>
            </div>
        @endif
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <!-- Match Details -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Match Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Status</p>
                <p class="font-semibold">{{ ucfirst($match->status) }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Scheduled</p>
                <p class="font-semibold">{{ $match->scheduled_at->format('M d, Y - g:i A') }}</p>
            </div>
            @if($match->started_at)
                <div>
                    <p class="text-gray-600 text-sm">Started</p>
                    <p class="font-semibold">{{ $match->started_at->format('g:i A') }}</p>
                </div>
            @endif
            @if($match->completed_at)
                <div>
                    <p class="text-gray-600 text-sm">Completed</p>
                    <p class="font-semibold">{{ $match->completed_at->format('M d, Y - g:i A') }}</p>
                </div>
            @endif
            @if($match->stream_url)
                <div>
                    <p class="text-gray-600 text-sm">Stream</p>
                    <a href="{{ $match->stream_url }}" target="_blank" class="text-indigo-600 hover:underline">Watch Live</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Player Performance -->
    @if($match->status === 'completed' && $match->playerPerformances->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Team 1 Performance -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">{{ $match->team1->name }} Performance</h3>
                <div class="space-y-4">
                    @foreach($match->playerPerformances->where('team_id', $match->team1_id) as $performance)
                        <div class="border-b pb-3">
                            <p class="font-semibold">{{ $performance->player->name }}</p>
                            <div class="grid grid-cols-4 gap-2 text-sm mt-2">
                                <div>
                                    <p class="text-gray-600">K/D/A</p>
                                    <p class="font-bold">{{ $performance->kills }}/{{ $performance->deaths }}/{{ $performance->assists }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">KDA</p>
                                    <p class="font-bold">{{ number_format($performance->kda_ratio, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Damage</p>
                                    <p class="font-bold">{{ number_format($performance->damage_dealt) }}</p>
                                </div>
                                @if($performance->accuracy)
                                    <div>
                                        <p class="text-gray-600">Accuracy</p>
                                        <p class="font-bold">{{ number_format($performance->accuracy, 1) }}%</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Team 2 Performance -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">{{ $match->team2->name }} Performance</h3>
                <div class="space-y-4">
                    @foreach($match->playerPerformances->where('team_id', $match->team2_id) as $performance)
                        <div class="border-b pb-3">
                            <p class="font-semibold">{{ $performance->player->name }}</p>
                            <div class="grid grid-cols-4 gap-2 text-sm mt-2">
                                <div>
                                    <p class="text-gray-600">K/D/A</p>
                                    <p class="font-bold">{{ $performance->kills }}/{{ $performance->deaths }}/{{ $performance->assists }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">KDA</p>
                                    <p class="font-bold">{{ number_format($performance->kda_ratio, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Damage</p>
                                    <p class="font-bold">{{ number_format($performance->damage_dealt) }}</p>
                                </div>
                                @if($performance->accuracy)
                                    <div>
                                        <p class="text-gray-600">Accuracy</p>
                                        <p class="font-bold">{{ number_format($performance->accuracy, 1) }}%</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Match Reviews -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Match Reviews</h2>
            @auth
                @if($match->status === 'completed')
                    <button onclick="document.getElementById('reviewForm').classList.toggle('hidden')" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        Write Review
                    </button>
                @endif
            @endauth
        </div>

        @foreach($match->reviews as $review)
            <div class="border-b pb-4 mb-4">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}" 
                             alt="{{ $review->user->name }}" 
                             class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="font-bold">{{ $review->user->name }}</p>
                            <div class="flex text-yellow-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        ⭐
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                    <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-700">{{ $review->review_text }}</p>
                <span class="text-xs text-gray-500 mt-2 inline-block">Category: {{ ucfirst($review->category) }}</span>
            </div>
        @endforeach

        @if($match->reviews->count() === 0)
            <p class="text-center text-gray-500 py-8">No reviews yet</p>
        @endif

        <!-- Review Form -->
        @auth
            <div id="reviewForm" class="hidden mt-6 pt-6 border-t">
                <form action="{{ route('matches.reviews.store', $match->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Rating</label>
                            <select name="rating" class="w-full border rounded-lg px-4 py-2" required>
                                <option value="">Select rating</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Category</label>
                            <select name="category" class="w-full border rounded-lg px-4 py-2" required>
                                <option value="overall">Overall</option>
                                <option value="gameplay">Gameplay</option>
                                <option value="organization">Organization</option>
                                <option value="fairness">Fairness</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Review</label>
                        <textarea name="review_text" rows="3" class="w-full border rounded-lg px-4 py-2" required></textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                        Submit Review
                    </button>
                </form>
            </div>
        @endauth
    </div>
</div>
@endsection

{{-- ============================================ --}}
{{-- resources/views/profile/show.blade.php --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-6">
            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                 alt="{{ $user->name }}" 
                 class="w-32 h-32 rounded-full border-4 border-white">
            <div>
                <h1 class="text-4xl font-bold mb-2">{{ $user->name }}</h1>
                <p class="text-xl mb-2">@{{ $user->username }}</p>
                <span class="bg-white text-indigo-600 px-4 py-1 rounded-full text-sm font-semibold">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Profile Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Profile Information</h2>
                    <a href="{{ route('profile.edit') }}" class="text-indigo-600 hover:underline">Edit Profile</a>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-gray-600 text-sm">Email</p>
                        <p class="font-semibold">{{ $user->email }}</p>
                    </div>
                    @if($user->phone)
                        <div>
                            <p class="text-gray-600 text-sm">Phone</p>
                            <p class="font-semibold">{{ $user->phone }}</p>
                        </div>
                    @endif
                    @if($user->bio)
                        <div>
                            <p class="text-gray-600 text-sm">Bio</p>
                            <p class="text-gray-700">{{ $user->bio }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-gray-600 text-sm">Member Since</p>
                        <p class="font-semibold">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- My Teams -->
            @if($user->teams->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-4">My Teams</h2>
                    <div class="space-y-4">
                        @foreach($user->teams as $team)
                            <div class="flex items-center justify-between border-b pb-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                                        {{ strtoupper(substr($team->tag, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold">{{ $team->name }}</p>
                                        <p class="text-sm text-gray-600">{{ ucfirst($team->pivot->role) }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('teams.show', $team->slug) }}" class="text-indigo-600 hover:underline text-sm">
                                    View Team →
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Organized Tournaments (for organizers) -->
            @if($user->isOrganizer() && $user->organizedTournaments->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4">My Tournaments</h2>
                    <div class="space-y-4">
                        @foreach($user->organizedTournaments as $tournament)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-bold">{{ $tournament->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $tournament->game->title }}</p>
                                        <span class="text-xs px-2 py-1 rounded mt-2 inline-block
                                            @if($tournament->status === 'ongoing') bg-green-100 text-green-800
                                            @elseif($tournament->status === 'completed') bg-gray-100 text-gray-800
                                            @else bg-blue-100 text-blue-800
                                            @endif">
                                            {{ str_replace('_', ' ', ucfirst($tournament->status)) }}
                                        </span>
                                    </div>
                                    <a href="{{ route('tournaments.show', $tournament->slug) }}" class="text-indigo-600 hover:underline text-sm">
                                        View →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Stats -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold mb-4">Statistics</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Teams</span>
                        <span class="font-bold">{{ $stats['total_teams'] }}</span>
                    </div>
                    @if($user->role === 'player')
                        <div class="flex justify-between">
                            <span class="text-gray-600">Teams Captained</span>
                            <span class="font-bold">{{ $stats['teams_captained'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Matches Played</span>
                            <span class="font-bold">{{ $stats['matches_played'] }}</span>
                        </div>
                    @endif
                    @if($user->isOrganizer())
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tournaments Organized</span>
                            <span class="font-bold">{{ $stats['tournaments_organized'] }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Reviews Written</span>
                        <span class="font-bold">{{ $stats['reviews_written'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('profile.edit') }}" class="block w-full text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                        Edit Profile
                    </a>
                    @if($user->role === 'player')
                        <a href="{{ route('teams.create') }}" class="block w-full text-center bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                            Create Team
                        </a>
                    @endif
                    @if($user->isOrganizer())
                        <a href="{{ route('tournaments.create') }}" class="block w-full text-center bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700">
                            Create Tournament
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection