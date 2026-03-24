<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <a href="{{ route('events.index') }}" class="flex items-center justify-between gap-x-3">
            @push('preloads')
                <link rel="preload" as="image" href="{{ asset('images/logo.png') }}">
            @endpush
            <img src="{{ asset('images/logo.png') }}" alt="{{ __('Logo') }}" width="50" class="rounded-2xl">
            <h3 class="font-bold text-3xl">SSIS Elevkår</h3>
        </a>

        <div class="flex gap-x-3 items-center">
            @auth
                <div class="flex space-x-3 mx-auto items-center">
                    @can('admin')
                        <a href="{{ route('admin.events.index') }}" class="btn {{ request()->routeIs('admin.events.*') ? 'btn-primary' : 'btn-outlined' }}">{{ __('Events') }}</a>
                        <a href="{{ route('admin.users.index') }}" class="btn {{ request()->routeIs('admin.users.*') ? 'btn-primary' : 'btn-outlined' }}">{{ __('Users') }}</a>
                    @endcan
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit" data-test="logout-button">{{ __('Log Out') }}</button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="btn btn-primary">
                    <a href="/login">{{ __('Sign In') }}</a>
                </div>
            @endguest
        </div>
    </div>
</nav>
