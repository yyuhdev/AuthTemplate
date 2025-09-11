@extends('template.default')

@section('content')
    <script>
        function openProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.style.display = 'flex';
        }

        function closeProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.style.display = 'none';
        }

        document.addEventListener('click', event => {
            if (event.srcElement == null) {
                closeProfileDropdown();
            }

            if (event.srcElement.id === 'profile-dropdown' || event.srcElement.id === 'profile-button') {
                return;
            }

            closeProfileDropdown();
        });
    </script>
    <nav class="nav">
        <div class="nav-left">
        </div>
        <div class="nav-right">
            @if(Auth::user())
                <div class="profile">
                    <div class="profile-header">
                        <i class="fa-solid fa-circle-user" onclick="openProfileDropdown()" id="profile-button"></i>
                    </div>

                    <div class="profile-dropdown" id="profile-dropdown">
                        <div class="dropdown-info">
                            <i class="fa-solid fa-circle-user icon"></i>
                            <p>{{ Auth::user()->name }}</p>
                        </div>
                        <div class="divider"></div>
                        <a href="{{ route('profile.account-settings') }}" class="dropdown-button">
                            <i class="fa-solid fa-pencil icon"></i>
                            <p>Edit Profile</p>
                        </a>
                        <a href="{{ route('logout') }}" class="dropdown-button">
                            <i class="fa-solid fa-right-from-bracket icon"></i>
                            <p>Logout</p>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </nav>

@endsection
