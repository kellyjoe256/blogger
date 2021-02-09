<nav class="space-x-4 text-gray-300 text-sm sm:text-base">
    @guest
        <a class="no-underline hover:underline" href="{{ route('login') }}">{{ __('Login') }}</a>
        @if (Route::has('register'))
            <a class="no-underline hover:underline" href="{{ route('register') }}">{{ __('Register') }}</a>
        @endif
    @else
        <a
            href="{{ route('dashboard') }}"
            class="text-gray-50 no-underline hover:underline"
        >{{ __('Dashboard') }}</a>

        <a
            href="{{ route('dashboard.posts') }}"
            class="text-gray-50 no-underline hover:underline"
        >{{ __('Posts') }}</a>

        <span>{{ Auth::user()->name }}</span>

        <a href="{{ route('logout') }}"
           class="no-underline hover:underline"
           onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            {{ csrf_field() }}
        </form>
    @endguest
</nav>
