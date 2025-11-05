<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'MR BLUESKY')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-black">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="flex-1">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-black border-t border-sky-900/30 mt-20">
                <div class="container mx-auto px-4 py-12">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <!-- About -->
                        <div>
                            <h3 class="text-xl font-black text-white mb-4 uppercase tracking-tight">MR BLUESKY</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">
                                The ultimate platform for managing esports tournaments, teams, and competitions.
                            </p>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h3 class="text-lg font-bold text-white mb-4 uppercase tracking-wide">Quick Links</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('games.index') }}" class="text-gray-400 hover:text-sky-500 transition text-sm">Games</a></li>
                                <li><a href="{{ route('tournaments.index') }}" class="text-gray-400 hover:text-sky-500 transition text-sm">Tournaments</a></li>
                                <li><a href="{{ route('teams.index') }}" class="text-gray-400 hover:text-sky-500 transition text-sm">Teams</a></li>
                                <li><a href="{{ route('matches.index') }}" class="text-gray-400 hover:text-sky-500 transition text-sm">Matches</a></li>
                            </ul>
                        </div>

                        <!-- For Users -->
                        <div>
                            <h3 class="text-lg font-bold text-white mb-4 uppercase tracking-wide">For Users</h3>
                            <ul class="space-y-2">
                                @guest
                                    <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-sky-500 transition text-sm">Sign Up</a></li>
                                    <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-sky-500 transition text-sm">Login</a></li>
                                @else
                                    <li><a href="{{ route('profile.show') }}" class="text-gray-400 hover:text-sky-500 transition text-sm">My Profile</a></li>
                                    <li><a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-sky-500 transition text-sm">Dashboard</a></li>
                                    @if(auth()->user()->role === 'player')
                                        <li><a href="{{ route('teams.create') }}" class="text-gray-400 hover:text-sky-500 transition text-sm">Create Team</a></li>
                                    @endif
                                    @if(auth()->user()->role === 'organizer' || auth()->user()->role === 'admin')
                                        <li><a href="{{ route('tournaments.create') }}" class="text-gray-400 hover:text-sky-500 transition text-sm">Create Tournament</a></li>
                                    @endif
                                @endguest
                            </ul>
                        </div>

                        <!-- Contact -->
                        <div>
                            <h3 class="text-lg font-bold text-white mb-4 uppercase tracking-wide">Contact</h3>
                            <ul class="space-y-2 text-gray-400 text-sm">
                                <li>support@mrbluesky.com</li>
                                <li>+254 712 345 678</li>
                                <li>Nairobi, Kenya</li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-t border-sky-900/30 mt-10 pt-8 text-center">
                        <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} MR BLUESKY. All rights reserved.</p>
                        <p class="text-gray-500 text-xs mt-2">Developed by Seth Jason Kimutai - Kabarak University</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
