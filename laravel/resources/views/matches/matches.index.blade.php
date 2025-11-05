@extends('layouts.app')

@section('title', 'Matches')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Matches</h1>
    
    <div class="space-y-4">
        @forelse($upcomingMatches as $match)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1 text-right">
                        <h4 class="font-bold text-lg">{{ $match->team1->name }}</h4>
                    </div>
                    <div class="px-8 text-center">
                        <span class="text-2xl font-bold text-gray-400">VS</span>
                        <p class="text-sm text-gray-500">{{ $match->scheduled_at->format('M d, g:i A') }}</p>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg">{{ $match->team2->name }}</h4>
                    </div>
                    <div>
                        <a href="{{ route('matches.show', $match->id) }}" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                            View
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">No upcoming matches</p>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $upcomingMatches->links() }}
    </div>
</div>
@endsection