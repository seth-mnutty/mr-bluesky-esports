@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>
    
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-2xl font-bold text-indigo-600">{{ \App\Models\User::count() }}</div>
            <div class="text-gray-600">Total Users</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-2xl font-bold text-purple-600">{{ \App\Models\Game::count() }}</div>
            <div class="text-gray-600">Games</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-2xl font-bold text-pink-600">{{ \App\Models\Tournament::count() }}</div>
            <div class="text-gray-600">Tournaments</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-2xl font-bold text-green-600">{{ \App\Models\Team::count() }}</div>
            <div class="text-gray-600">Teams</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('admin.games.index') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition text-center font-semibold">
            Manage Games
        </a>
        <a href="{{ route('admin.tournaments.index') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition text-center font-semibold">
            Manage Tournaments
        </a>
        <a href="{{ route('admin.users.index') }}" class="bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition text-center font-semibold">
            Manage Users
        </a>
        <a href="{{ route('admin.reviews.games') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition text-center font-semibold">
            Review Management
        </a>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Activity</h2>
        <div class="space-y-4">
            <!-- Add recent activity items here -->
            <p class="text-gray-500">No recent activity to display.</p>
        </div>
    </div>
</div>
@endsection
