@extends('layouts.app')

@section('title', 'Teams - BLUESKY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl sm:text-5xl font-black text-white mb-2 uppercase tracking-tight">BLUESKY Teams</h1>
                <p class="text-gray-400 text-lg">Discover competitive esports teams</p>
            </div>
            @auth
                @if(auth()->user()->role === 'player')
                    <a href="{{ route('teams.create') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-sky-500 hover:to-blue-600 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-bold border border-sky-500/50">
                        Create Team
                    </a>
                @endif
            @endauth
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($teams as $team)
                <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-xl overflow-hidden hover:border-sky-500/60 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl hover:shadow-sky-900/30">
                    <div class="h-32 bg-gradient-to-br from-sky-900/40 to-blue-900/20 flex items-center justify-center relative overflow-hidden">
                        @if($team->logo)
                            <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-full h-full object-cover opacity-90">
                        @else
                            <div class="text-sky-400 text-4xl font-black">{{ substr($team->name, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="p-6 bg-gradient-to-b from-gray-900 to-black">
                        <h3 class="font-bold text-xl text-white mb-2">{{ $team->name }}</h3>
                        <p class="text-gray-400 mb-2">Tag: <span class="text-sky-400 font-bold">{{ $team->tag }}</span></p>
                        <p class="text-sm text-gray-500 mb-4">
                            Members: <span class="text-white font-semibold">{{ $team->members()->count() }}/{{ $team->max_members }}</span>
                        </p>
                        @if($team->win_rate)
                            <div class="mb-4">
                                <p class="text-xs text-gray-400 mb-1 uppercase tracking-wider">Win Rate</p>
                                <p class="text-2xl font-black text-sky-500">{{ number_format($team->win_rate, 1) }}%</p>
                            </div>
                        @endif
                        <a href="{{ route('teams.show', $team->slug) }}" class="block w-full text-center bg-gradient-to-r from-sky-600 to-blue-700 text-white py-2.5 rounded-lg hover:from-sky-500 hover:to-blue-600 transition font-bold text-sm border border-sky-500/50">
                            View Team
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20">
                    <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-sky-900/30">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 text-lg font-medium mb-2">No teams available</p>
                    <p class="text-gray-500 text-sm">Check back later for new teams</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-10">
            {{ $teams->links() }}
        </div>
    </div>
</div>
@endsection
