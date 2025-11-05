@extends('layouts.app')

@section('title', 'Teams')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Teams</h1>
                <p class="text-gray-600 text-lg">Browse competitive esports teams</p>
            </div>
            @auth
                @if(auth()->user()->role === 'player')
                    <a href="{{ route('teams.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold">
                        Create Team
                    </a>
                @endif
            @endauth
        </div>

        <!-- Teams Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($teams as $team)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="h-40 bg-gradient-to-br from-pink-500 via-purple-500 to-indigo-500 flex items-center justify-center relative overflow-hidden">
                        @if($team->logo)
                            <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-white text-3xl font-bold">{{ substr($team->name, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-bold text-xl text-gray-900">{{ $team->name }}</h3>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $team->tag }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ Str::limit($team->description ?? '', 80) }}</p>
                        <div class="flex items-center justify-between mb-5">
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">{{ $team->members()->count() }}</span>
                                <span class="text-gray-500">/{{ $team->max_members }} members</span>
                            </div>
                            @if($team->win_rate)
                                <div class="text-sm">
                                    <span class="font-semibold text-green-600">{{ number_format($team->win_rate, 1) }}%</span>
                                    <span class="text-gray-500">win rate</span>
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('teams.show', $team->slug) }}" class="block w-full text-center bg-pink-600 text-white py-2.5 rounded-xl hover:bg-pink-700 transition font-semibold text-sm">
                            View Team
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-lg font-medium mb-2">No teams available</p>
                    <p class="text-gray-500 text-sm">Teams will appear here when created</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-10">
            {{ $teams->links() }}
        </div>
    </div>
</div>
@endsection
