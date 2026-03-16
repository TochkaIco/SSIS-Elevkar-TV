<x-layout title="User Management">
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold text-foreground">User Management</h1>
            <p class="text-muted-foreground text-sm mt-2">Manage user permissions and accounts.</p>
        </header>

        <div class="mt-8">
            <div class="overflow-x-auto border border-border rounded-xl">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-border bg-card/50 text-muted-foreground uppercase text-xs tracking-wider">
                            <th class="py-4 px-6 font-semibold">Name</th>
                            <th class="py-4 px-6 font-semibold">Email</th>
                            <th class="py-4 px-6 font-semibold">Role</th>
                            <th class="py-4 px-6 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach($users as $user)
                            <tr class="hover:bg-card/30 transition-colors">
                                <td class="py-4 px-6">
                                    <span class="font-medium text-foreground">{{ $user->name }}</span>
                                </td>
                                <td class="py-4 px-6 text-muted-foreground">
                                    {{ $user->email }}
                                </td>
                                <td class="py-4 px-6">
                                    <form 
                                        action="{{ route('admin.users.update', $user) }}" 
                                        method="POST" 
                                        x-data="{ is_admin: {{ $user->is_admin ? 'true' : 'false' }} }" 
                                        x-ref="form_{{ $user->id }}"
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="is_admin" :value="is_admin ? 1 : 0">
                                        
                                        <label class="inline-flex items-center cursor-pointer group">
                                            <div class="relative">
                                                <input 
                                                    type="checkbox" 
                                                    class="sr-only peer" 
                                                    x-model="is_admin"
                                                    @change="$nextTick(() => $refs['form_{{ $user->id }}'].submit())"
                                                >
                                                <div class="w-11 h-6 bg-input rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                            </div>
                                            <span class="ms-3 text-sm font-medium text-foreground min-w-[3.5rem]">
                                                <span x-text="is_admin ? 'Admin' : 'User'"></span>
                                            </span>
                                        </label>
                                    </form>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    @if($user->id !== auth()->id())
                                        <form 
                                            action="{{ route('admin.users.destroy', $user) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                                            class="inline-block"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400 text-sm font-medium transition-colors cursor-pointer">
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-muted-foreground italic">(You)</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
