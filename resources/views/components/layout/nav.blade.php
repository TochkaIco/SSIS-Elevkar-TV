@props(['type' => ''])
<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <div class="flex items-center justify-between gap-x-3">
            <img src="/images/logo.png" alt="logo" width="50" class="rounded-2xl">
            <h3 class="font-bold text-3xl">SSIS Elevkår</h3>
        </div>

        <div class="flex gap-x-3 items-center">
            @if($type!=='no-login')
                @auth
                    <div class="flex space-x-3 mx-auto items-center">
                        @can('admin')
                            <a href="{{ route('admin.events.index') }}" class="btn {{ request()->routeIs('admin.events.*') ? 'btn-primary' : 'btn-outlined' }}">Events</a>
                            <a href="{{ route('admin.users.index') }}" class="btn {{ request()->routeIs('admin.users.*') ? 'btn-primary' : 'btn-outlined' }}">Users</a>
                        @endcan
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" data-test="logout-button">Log Out</button>
                        </form>
                    </div>
                @endauth

                @guest
                    <div class="btn btn-primary">
                        <a href="/login">Sign In</a>
                    </div>
                @endguest
            @else
                <p>See more at {{ config('app.public-url') }}</p>
            @endif
        </div>
    </div>
</nav>
