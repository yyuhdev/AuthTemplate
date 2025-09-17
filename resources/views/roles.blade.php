@extends('template.default')

@section('content')
    <script>
        function openCreationModal() {
            const modal = document.getElementById('creation-modal');
            modal.style.display = 'flex';
        }

        function closeCreationModal() {
            const modal = document.getElementById('creation-modal');
            modal.style.display = 'none';
        }

        document.addEventListener('click', event => {
            if (event.srcElement == null) {
                closeCreationModal();
            }

            if (event.srcElement.id === 'creation-modal' || event.srcElement.closest('#creation-modal') || event.srcElement.id === 'create-button') {
                return;
            }

            closeCreationModal();
        });

    </script>


    <div class="file-table-container">
        <h3 class="file-list-title">Roles</h3>
        <button class="create-btn" onclick="openCreationModal()" id="create-button">Create New</button>

        <table class="file-table">
            <thead>
            <tr>
                <th>Role ID</th>
                <th>Users</th>
                <th>Role Name</th>
                <th>Allowed Pages</th>
                <th style="width: 60px;">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($roles as $role)
                <tr class="file-item">
                    <td class="file-name">{{ $role->name }}</td>
                    <td class="file-name">{{ \App\Models\User::where('role', $role->name)->count() }}</td>
                    <td class="file-name">{{ $role->display_name }}</td>
                    <td class="file-name">{{ implode(', ', json_decode($role->allowed_pages ?? '[]')) }}</td>
                    @if(!$role->default)
                        <td class="actions">
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="fa-solid fa-trash delete-btn"></button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="file-empty">No roles created yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <form action="{{ route('roles.store') }}" method="POST" class="create-role-form" id="creation-modal">
        <p class="file-list-title">Create a Role</p>
        @csrf
        <input type="text" name="display_name" placeholder="Role Display Name" required>
        <input type="text" name="name" placeholder="Role ID (unique)" required>

        <label for="allowed_pages">Allowed Pages:</label>
        <select name="allowed_pages[]" id="allowed_pages" multiple>
            <option value="*">*</option>
            @foreach($routes as $route)
                @if($route->getName())
                    <option value="{{ $route->getName() }}">{{ $route->getName() }}</option>
                @endif
            @endforeach
        </select>

        <button type="submit" class="create-btn">Create Role</button>
    </form>
@endsection
