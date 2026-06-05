<?php
$viewsDir = __DIR__ . '/resources/views/super-admin/';

$layouts = "x-app-layout";

$files = [
    'roles/index.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Roles</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('super-admin.roles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 mb-4">Tambah Role</a>
                
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Nama Role</th>
                            <th class="py-2 px-4 border-b text-left">Permissions</th>
                            <th class="py-2 px-4 border-b text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $role->name }}</td>
                                <td class="py-2 px-4 border-b">
                                    @foreach($role->permissions as $perm)
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $perm->name }}</span>
                                    @endforeach
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('super-admin.roles.edit', $role) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                    @if($role->name !== 'super_admin')
                                    <form action="{{ route('super-admin.roles.destroy', $role) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
HTML,

    'roles/create.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Role</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('super-admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Role</label>
                        <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Permissions</label>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach($permissions as $perm)
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2">{{ $perm->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                    <a href="{{ route('super-admin.roles.index') }}" class="text-gray-500 ml-4">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
HTML,

    'roles/edit.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Role</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('super-admin.roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Role</label>
                        <input type="text" name="name" value="{{ $role->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Permissions</label>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach($permissions as $perm)
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" 
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                                        <span class="ml-2">{{ $perm->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                    <a href="{{ route('super-admin.roles.index') }}" class="text-gray-500 ml-4">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
HTML,

    'permissions/index.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Permissions</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('super-admin.permissions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 mb-4">Tambah Permission</a>
                
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Nama Permission</th>
                            <th class="py-2 px-4 border-b text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $perm)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $perm->name }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('super-admin.permissions.edit', $perm) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                    <form action="{{ route('super-admin.permissions.destroy', $perm) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
HTML,

    'permissions/create.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Permission</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('super-admin.permissions.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Permission</label>
                        <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                    <a href="{{ route('super-admin.permissions.index') }}" class="text-gray-500 ml-4">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
HTML,

    'permissions/edit.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Permission</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('super-admin.permissions.update', $permission) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Permission</label>
                        <input type="text" name="name" value="{{ $permission->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                    <a href="{{ route('super-admin.permissions.index') }}" class="text-gray-500 ml-4">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
HTML,

    'users/index.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen User (Mutasi)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Nama</th>
                            <th class="py-2 px-4 border-b text-left">Email</th>
                            <th class="py-2 px-4 border-b text-left">Role Aktif</th>
                            <th class="py-2 px-4 border-b text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                <td class="py-2 px-4 border-b">
                                    @foreach($user->roles as $r)
                                        <span class="inline-block bg-blue-100 text-blue-800 rounded-full px-3 py-1 text-xs font-semibold mr-1">{{ $r->name }}</span>
                                    @endforeach
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('super-admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Ubah Role</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
HTML,

    'users/edit.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ubah Role: {{ $user->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('super-admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Role</label>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach($roles as $role)
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                        <span class="ml-2">{{ $role->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Menambahkan/mengurangi role ini akan dicatat dalam Audit Trail.</p>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Role</button>
                    <a href="{{ route('super-admin.users.index') }}" class="text-gray-500 ml-4">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
HTML,

    'audit-logs/index.blade.php' => <<<'HTML'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Audit Trail Logs</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Filter Form -->
                <form action="{{ route('super-admin.audit-logs.index') }}" method="GET" class="mb-6 flex flex-wrap gap-4 bg-gray-50 p-4 rounded-md">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipe Log</label>
                        <select name="log_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Semua</option>
                            @foreach($logNames as $name)
                                <option value="{{ $name }}" {{ request('log_name') == $name ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Event</label>
                        <select name="event" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Semua</option>
                            @foreach($events as $ev)
                                <option value="{{ $ev }}" {{ request('event') == $ev ? 'selected' : '' }}>{{ $ev }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">User (Pelaku)</label>
                        <select name="causer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Semua</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ request('causer_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Filter</button>
                        <a href="{{ route('super-admin.audit-logs.index') }}" class="ml-2 text-gray-600 hover:text-gray-900 px-4 py-2">Reset</a>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b text-left">Waktu</th>
                                <th class="py-2 px-4 border-b text-left">Tipe</th>
                                <th class="py-2 px-4 border-b text-left">Event</th>
                                <th class="py-2 px-4 border-b text-left">Pelaku</th>
                                <th class="py-2 px-4 border-b text-left">Deskripsi</th>
                                <th class="py-2 px-4 border-b text-left">Target ID</th>
                                <th class="py-2 px-4 border-b text-left">Properti (Perubahan)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td class="py-2 px-4 border-b whitespace-nowrap">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="py-2 px-4 border-b">{{ $log->log_name }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $log->event == 'created' || $log->event == 'login' ? 'bg-green-100 text-green-800' : 
                                               ($log->event == 'updated' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($log->event == 'deleted' || $log->event == 'logout' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ $log->event }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b">{{ $log->causer ? $log->causer->name : 'Sistem' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $log->description }}</td>
                                    <td class="py-2 px-4 border-b">{{ $log->subject_type ? class_basename($log->subject_type).'#'.$log->subject_id : '-' }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @if($log->properties && count($log->properties) > 0)
                                            <details>
                                                <summary class="cursor-pointer text-indigo-600">Lihat Detail</summary>
                                                <pre class="text-xs mt-2 bg-gray-50 p-2 rounded max-w-xs overflow-x-auto">{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                                            </details>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center text-gray-500">Tidak ada log aktivitas ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
HTML
];

foreach (\$files as \$path => \$content) {
    file_put_contents(\$viewsDir . \$path, \$content);
}
echo "Views created successfully.\n";
