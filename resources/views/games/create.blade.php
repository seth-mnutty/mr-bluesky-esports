@extends('layouts.app')

@section('title', 'Create New Game - BLUESKY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
            <div class="mb-8">
                <h1 class="text-4xl sm:text-5xl font-black text-white mb-2 uppercase tracking-tight">Create New Game</h1>
                <p class="text-gray-400 text-lg">Add a new game to the BLUESKY platform</p>
            </div>

            <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Game Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder-gray-500" placeholder="Enter game title">
                        @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Description *</label>
                        <textarea name="description" rows="6" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder-gray-500" placeholder="Describe the game...">{{ old('description') }}</textarea>
                        @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Genre *</label>
                            <input type="text" name="genre" value="{{ old('genre') }}" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder-gray-500" placeholder="e.g., MOBA, FPS">
                            @error('genre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Platform *</label>
                            <select name="platform" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                                <option value="">Select Platform</option>
                                <option value="PC" {{ old('platform') == 'PC' ? 'selected' : '' }}>PC</option>
                                <option value="PlayStation" {{ old('platform') == 'PlayStation' ? 'selected' : '' }}>PlayStation</option>
                                <option value="Xbox" {{ old('platform') == 'Xbox' ? 'selected' : '' }}>Xbox</option>
                                <option value="Mobile" {{ old('platform') == 'Mobile' ? 'selected' : '' }}>Mobile</option>
                                <option value="Cross-platform" {{ old('platform') == 'Cross-platform' ? 'selected' : '' }}>Cross-platform</option>
                            </select>
                            @error('platform')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Publisher</label>
                            <input type="text" name="publisher" value="{{ old('publisher') }}" class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder-gray-500" placeholder="e.g., Riot Games">
                            @error('publisher')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Release Date</label>
                            <input type="date" name="release_date" value="{{ old('release_date') }}" class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                            @error('release_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Min Players *</label>
                            <input type="number" name="min_players" value="{{ old('min_players', 1) }}" min="1" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition" placeholder="1">
                            @error('min_players')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Max Players *</label>
                            <input type="number" name="max_players" value="{{ old('max_players', 1) }}" min="1" required class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition" placeholder="10">
                            @error('max_players')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Cover Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-sky-900/30 border-dashed rounded-xl hover:border-sky-500/60 transition bg-gray-900/50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400">
                                    <label for="cover_image" class="relative cursor-pointer rounded-md font-bold text-sky-500 hover:text-sky-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-sky-500">
                                        <span>Upload a file</span>
                                        <input id="cover_image" name="cover_image" type="file" accept="image/*" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                            </div>
                        </div>
                        @error('cover_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('games.index') }}" class="px-6 py-3 border-2 border-sky-900/30 rounded-xl font-bold text-gray-300 hover:bg-gray-800 hover:border-sky-500/60 transition">Cancel</a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-sky-600 to-blue-700 text-white rounded-xl font-bold hover:from-sky-500 hover:to-blue-600 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 border border-sky-500/50">Create Game</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
