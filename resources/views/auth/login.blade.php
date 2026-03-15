<x-layout title="Login" class="flex mx-auto items-center justify-center h-screen">
    <div class="flex flex-col bg-base-200 border-base-300 rounded-box w-xs border p-4 space-y-4 rounded-2xl items-center justify-center">
        <img src="/images/logo.png" alt="logo" width="150" class="rounded-2xl">
        <h2 class="text-3xl">Sign In</h2>
        <a href="{{ route('auth.google') }}" class="btn btn-primary w-full content-center h-15">Login via Google</a>
        <a href="/" class="btn btn-outlined w-full">Go Back</a>
    </div>
</x-layout>
