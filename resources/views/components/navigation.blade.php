<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-800">
                    {{ config('app.name', 'Laravel') }}
                </a>

                @auth
                    @if(auth()->user()->id === 1)
                        <x-nav-link href="{{ route('matches.indexUser') }}" :active="request()->routeIs('matches.indexUser')">Your Matches</x-nav-link>
                        <x-nav-link href="{{ route('tournaments.indexUser') }}" :active="request()->routeIs('tournaments.indexUser')">Your Tournaments</x-nav-link>
                        <x-nav-link href="{{ route('tournaments.index') }}" :active="request()->routeIs('tournaments.index')">Matches due</x-nav-link>
                        <x-nav-link href="{{ route('matches.index') }}" :active="request()->routeIs('matches.index')">All Matches (archive)</x-nav-link>
                        <x-nav-link href="{{ route('tournaments.index') }}" :active="request()->routeIs('tournaments.index')">All Tournaments (archive)</x-nav-link>
                    @else
                        <x-nav-link href="{{ route('matches.indexUser') }}" :active="request()->routeIs('matches.indexUser')">Your Matches</x-nav-link>
                        <x-nav-link href="{{ route('tournaments.indexUser') }}" :active="request()->routeIs('tournaments.indexUser')">Your Tournaments</x-nav-link>
                    @endif
                @endauth
            </div>
            <div class="flex items-center space-x-4">
                @guest
                    <x-nav-link href="{{ route('login') }}">{{ __('Login') }}</x-nav-link>
                    <x-nav-link href="{{ route('register') }}">{{ __('Register') }}</x-nav-link>
                @else
                    <span class="text-gray-800">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">
                            {{ __('Logout') }}
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>