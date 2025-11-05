@extends('layouts.app')

@section('title', 'Create Match')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Create Match for {{ $tournament->name }}</h1>

            <form action="{{ route('matches.store', $tournament->slug) }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Team 1 *</label>
                        <select name="team1_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select Team 1</option>
                            @foreach($registeredTeams as $registration)
                                <option value="{{ $registration->team->id }}">{{ $registration->team->name }}</option>
                            @endforeach
                        </select>
                        @error('team1_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Team 2 *</label>
                        <select name="team2_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select Team 2</option>
                            @foreach($registeredTeams as $registration)
                                <option value="{{ $registration->team->id }}">{{ $registration->team->name }}</option>
                            @endforeach
                        </select>
                        @error('team2_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Scheduled Date & Time *</label>
                        <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('scheduled_at')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('tournaments.show', $tournament->slug) }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Cancel</a>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">Create Match</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
