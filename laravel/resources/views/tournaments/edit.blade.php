@extends('layouts.app')

@section('title', 'Edit Tournament - BLUESKY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
            <div class="mb-8">
                <h1 class="text-4xl sm:text-5xl font-black text-white mb-2 uppercase tracking-tight">Edit Tournament</h1>
                <p class="text-gray-400 text-lg">Update tournament information</p>
            </div>

            <form action="{{ route('tournaments.update', $tournament->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Tournament Name *</label>
                        <input type="text" name="name" value="{{ old('name', $tournament->name) }}" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder-gray-500" placeholder="Enter tournament name">
                        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Game *</label>
                        <select name="game_id" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                            <option value="">Select Game</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}" {{ old('game_id', $tournament->game_id) == $game->id ? 'selected' : '' }}>{{ $game->title }}</option>
                            @endforeach
                        </select>
                        @error('game_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Description *</label>
                        <textarea name="description" rows="4" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder-gray-500" placeholder="Describe your tournament...">{{ old('description', $tournament->description) }}</textarea>
                        @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Start Date *</label>
                            <input type="datetime-local" name="tournament_start" value="{{ old('tournament_start', $tournament->tournament_start?->format('Y-m-d\TH:i')) }}" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                            @error('tournament_start')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">End Date *</label>
                            <input type="datetime-local" name="tournament_end" value="{{ old('tournament_end', $tournament->tournament_end?->format('Y-m-d\TH:i')) }}" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                            @error('tournament_end')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Format *</label>
                            <select name="format" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                                <option value="">Select Format</option>
                                <option value="Single Elimination" {{ old('format', $tournament->format) == 'Single Elimination' ? 'selected' : '' }}>Single Elimination</option>
                                <option value="Double Elimination" {{ old('format', $tournament->format) == 'Double Elimination' ? 'selected' : '' }}>Double Elimination</option>
                                <option value="Round Robin" {{ old('format', $tournament->format) == 'Round Robin' ? 'selected' : '' }}>Round Robin</option>
                            </select>
                            @error('format')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Max Teams *</label>
                            <input type="number" name="max_teams" value="{{ old('max_teams', $tournament->max_teams) }}" min="2" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition" placeholder="e.g., 16">
                            @error('max_teams')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Prize Pool (Kshs)</label>
                        <input type="number" name="prize_pool" value="{{ old('prize_pool', $tournament->prize_pool) }}" min="0" step="0.01" class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition" placeholder="e.g., 50000">
                        @error('prize_pool')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Banner Image</label>
                        @if($tournament->banner_image)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $tournament->banner_image) }}" alt="Current banner" class="w-full max-w-md h-32 object-cover rounded-xl border border-sky-900/30">
                                <p class="text-xs text-gray-500 mt-2">Current banner image</p>
                            </div>
                        @endif
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-sky-900/30 border-dashed rounded-xl hover:border-sky-500/60 transition bg-gray-900/50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400">
                                    <label for="banner_image" class="relative cursor-pointer rounded-md font-bold text-sky-500 hover:text-sky-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-sky-500">
                                        <span>Upload a file</span>
                                        <input id="banner_image" name="banner_image" type="file" accept="image/*" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                            </div>
                        </div>
                        @error('banner_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('tournaments.show', $tournament->slug) }}" class="px-6 py-3 border-2 border-sky-900/30 rounded-xl font-bold text-gray-300 hover:bg-gray-800 hover:border-sky-500/60 transition">Cancel</a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-sky-600 to-blue-700 text-white rounded-xl font-bold hover:from-sky-500 hover:to-blue-600 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 border border-sky-500/50">Update Tournament</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
