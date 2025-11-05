@extends('layouts.app')

@section('title', 'Create Team - BLUESKY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-gradient-to-br from-gray-900 to-black border border-sky-900/30 rounded-2xl shadow-xl p-8">
            <div class="mb-8">
                <h1 class="text-4xl sm:text-5xl font-black text-white mb-2 uppercase tracking-tight">Create New Team</h1>
                <p class="text-gray-400 text-lg">Form your esports team and start competing in tournaments</p>
            </div>

            <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Team Name -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Team Name *</label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder-gray-500"
                               placeholder="Enter your team name">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Team Tag -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Team Tag *</label>
                        <input type="text" 
                               name="tag" 
                               value="{{ old('tag') }}" 
                               required 
                               maxlength="10"
                               class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition uppercase placeholder-gray-500"
                               placeholder="TAG (max 10 characters)">
                        <p class="text-xs text-gray-500 mt-1">Short tag used in matches (e.g., TSM, C9, G2)</p>
                        @error('tag')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Team Description</label>
                        <textarea name="description" 
                                  rows="4" 
                                  class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition placeholder-gray-500"
                                  placeholder="Tell us about your team...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Logo Upload -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Team Logo</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-sky-900/30 border-dashed rounded-xl hover:border-sky-500/60 transition bg-gray-900/50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400">
                                    <label for="logo" class="relative cursor-pointer rounded-md font-bold text-sky-500 hover:text-sky-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-sky-500">
                                        <span>Upload a file</span>
                                        <input id="logo" name="logo" type="file" accept="image/*" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        @error('logo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Members -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 uppercase text-xs tracking-wider">Maximum Team Members *</label>
                        <select name="max_members" 
                                required 
                                class="w-full bg-gray-900 border border-sky-900/30 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                            @for($i = 2; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('max_members', 5) == $i ? 'selected' : '' }}>
                                    {{ $i }} {{ $i == 1 ? 'member' : 'members' }}
                                </option>
                            @endfor
                        </select>
                        <p class="text-xs text-gray-500 mt-1">How many players can be on your team?</p>
                        @error('max_members')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex items-center justify-end space-x-4">
                    <a href="{{ route('teams.index') }}" class="px-6 py-3 border-2 border-sky-900/30 rounded-xl font-bold text-gray-300 hover:bg-gray-800 hover:border-sky-500/60 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-sky-600 to-blue-700 text-white rounded-xl font-bold hover:from-sky-500 hover:to-blue-600 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 border border-sky-500/50">
                        Create Team
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-sky-900/20 border border-sky-900/30 rounded-xl p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-sky-400">Important Information</h3>
                    <div class="mt-2 text-sm text-gray-300">
                        <ul class="list-disc list-inside space-y-1">
                            <li>You will automatically become the team captain</li>
                            <li>Team names and tags must be unique</li>
                            <li>You can invite members after creating the team</li>
                            <li>Teams can register for tournaments once created</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
