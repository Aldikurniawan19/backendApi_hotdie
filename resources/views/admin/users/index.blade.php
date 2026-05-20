@extends('admin.layouts.app')
@section('title', 'Users')
@section('page-title', 'Users')

@section('content')
    <div class="mb-6"><p class="text-gray-500 text-sm">Daftar pengguna terdaftar</p></div>

    <div class="bg-surface-card border border-surface-border rounded-xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-surface-border">
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">User</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="table-row border-b border-surface-border/50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-brand/20 text-brand rounded-full flex items-center justify-center text-sm font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <p class="text-gray-900 font-medium text-sm">{{ $user->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-6 py-16 text-center text-gray-500 text-sm">Belum ada user</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
