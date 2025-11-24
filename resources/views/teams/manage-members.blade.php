@extends('layouts.app')

@section('title', 'Manage Members - ' . $team->name . ' - BLUESKY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-black text-white uppercase tracking-tight">Manage Members</h1>
                    <p class="text-gray-400">Manage roster for <span class="text-sky-400 font-bold">{{ $team->name }}</span></p>
                </div>
                <a href="{{ route('teams.show', $team->slug) }}" class="text-gray-400 hover:text-white transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Team
                </a>
            </div>

            <!-- Add Member Section -->
            <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8 mb-8">
                <h2 class="text-xl font-black text-white mb-6 uppercase tracking-tight">Add New Member</h2>
                
                @if($team->members()->count() >= $team->max_members)
                    <div class="bg-red-900/20 border border-red-900/50 text-red-400 px-4 py-3 rounded-xl">
                        Team has reached maximum capacity ({{ $team->max_members }} members).
                    </div>
                @else
                    <form action="{{ route('teams.members.add', $team->slug) }}" method="POST" class="flex gap-4">
                        @csrf
                        <div class="flex-1">
                            <select name="user_id" class="w-full bg-black/50 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition appearance-none">
                                <option value="">Select a user to add...</option>
                                @foreach($availableUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-48">
                            <select name="role" class="w-full bg-black/50 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition appearance-none">
                                <option value="player">Player</option>
                                <option value="substitute">Substitute</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-6 py-3 rounded-xl font-bold hover:from-sky-500 hover:to-blue-600 transition border border-sky-500/50">
                            Add Member
                        </button>
                    </form>
                @endif
            </div>

            <!-- Current Members List -->
            <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
                <h2 class="text-xl font-black text-white mb-6 uppercase tracking-tight">Current Roster</h2>
                
                <div class="space-y-4">
                    @foreach($team->members as $member)
                        <div class="flex items-center justify-between p-4 bg-gray-900/50 rounded-xl border border-sky-900/30">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-sky-600 to-blue-700 rounded-xl flex items-center justify-center border border-sky-500/50">
                                    <span class="text-white font-bold">{{ substr($member->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-bold text-white">{{ $member->name }}</h3>
                                        @if($member->id === $team->captain_id)
                                            <span class="text-xs bg-sky-900/50 text-sky-400 px-2 py-0.5 rounded border border-sky-800/50 font-bold uppercase">Captain</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-400">{{ ucfirst($member->pivot->role) }} • Joined {{ \Carbon\Carbon::parse($member->pivot->joined_at)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            @if($member->id !== $team->captain_id)
                                <form action="{{ route('teams.members.remove', ['slug' => $team->slug, 'userId' => $member->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this member?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 font-bold text-sm transition px-4 py-2 hover:bg-red-900/20 rounded-lg">
                                        Remove
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
