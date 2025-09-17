@extends('template.default')

@section('content')
    <div class="file-table-container">
        <h3 class="file-list-title">Users</h3>

        <table class="file-table">
            <thead>
            <tr>
                <th>Username</th>
                <th>ID</th>
                <th>Role</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr class="file-item">
                    <td class="file-name">{{ $user->name }}</td>
                    <td class="file-name">{{ $user->id }}</td>
                    <td class="file-name">{{ $user->role }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="file-empty">No users created yet. Wait... how are you able to see this if...?</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
