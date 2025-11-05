<nav x-data="{ open: false }" class="bg-black border-b border-sky-900/30 shadow-lg sticky top-0 z-50 backdrop-blur-sm bg-opacity-95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-sky-600 to-blue-700 rounded-lg flex items-center justify-center shadow-lg border border-sky-500/50">
                            <span class="text-white font-black text-lg">M</span>
                        </div>
                        <span class="text-xl font-black text-white hidden sm:inline uppercase tracking-tight">MR BLUESKY</span>
                    </a>
                </div>

                <div class="hidden space-x-1 sm:ml-10 sm:flex">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ request()->routeIs('home') ? 'bg-sky-900/50 text-sky-400 border border-sky-800/50' : 'text-gray-300 hover:bg-gray-900 hover:text-white' }}">
                        Home
                    </a>
                    <a href="{{ route('tournaments.index') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ request()->routeIs('tournaments.*') ? 'bg-sky-900/50 text-sky-400 border border-sky-800/50' : 'text-gray-300 hover:bg-gray-900 hover:text-white' }}">
                        Tournaments
                    </a>
                    <a href="{{ route('games.index') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ request()->routeIs('games.*') ? 'bg-sky-900/50 text-sky-400 border border-sky-800/50' : 'text-gray-300 hover:bg-gray-900 hover:text-white' }}">
                        Games
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ request()->routeIs('dashboard') ? 'bg-sky-900/50 text-sky-400 border border-sky-800/50' : 'text-gray-300 hover:bg-gray-900 hover:text-white' }}">
                            Dashboard
                        </a>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-bold text-gray-300 hover:bg-gray-900 hover:text-white focus:outline-none transition-colors border border-transparent hover:border-sky-900/50">
                            <div class="w-8 h-8 bg-gradient-to-br from-sky-600 to-blue-700 rounded-lg flex items-center justify-center border border-sky-500/50">
                                <span class="text-white text-xs font-black">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="font-bold">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-gray-900 rounded-xl shadow-xl py-2 border border-sky-900/30 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-3 text-sm text-red-500 hover:bg-red-900/20 transition-colors">Log Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white text-sm font-bold transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-sky-600 to-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:from-sky-500 hover:to-blue-600 transition-all shadow-lg border border-sky-500/50">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 focus:outline-none transition-colors border border-transparent hover:border-sky-900/50">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" x-cloak class="sm:hidden border-t border-sky-900/30 bg-black">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-base font-bold text-gray-300 hover:bg-gray-900 hover:text-white">Home</a>
            <a href="{{ route('tournaments.index') }}" class="block px-3 py-2 rounded-lg text-base font-bold text-gray-300 hover:bg-gray-900 hover:text-white">Tournaments</a>
            <a href="{{ route('games.index') }}" class="block px-3 py-2 rounded-lg text-base font-bold text-gray-300 hover:bg-gray-900 hover:text-white">Games</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-bold text-gray-300 hover:bg-gray-900 hover:text-white">Dashboard</a>
            @endauth
        </div>

        <div class="pt-4 pb-3 border-t border-sky-900/30 px-4">
            @auth
                <div class="px-3 mb-3">
                    <div class="text-base font-bold text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-base font-bold text-gray-300 hover:bg-gray-900 hover:text-white">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg text-base font-bold text-red-500 hover:bg-red-900/20">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-base font-bold text-gray-300 hover:bg-gray-900 hover:text-white">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg text-base font-bold text-gray-300 hover:bg-gray-900 hover:text-white">Register</a>
            @endauth
        </div>
    </div>
</nav>
