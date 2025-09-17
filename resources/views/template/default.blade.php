<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>

<script>
    function openProfileDropdown() {
        const dropdown = document.getElementById('profile-dropdown');
        dropdown.style.display = 'flex';
    }

    function closeProfileDropdown() {
        const dropdown = document.getElementById('profile-dropdown');
        dropdown.style.display = 'none';
    }

    function openNotifications() {
        const notifications = document.getElementById('notifications');
        const overlay = document.getElementById('overlay');

        overlay.style.display = 'block';
        notifications.style.display = 'flex';

        setTimeout(() => {
            overlay.classList.add('show');
        }, 10);
    }

    function closeNotifications() {
        const notifications = document.getElementById('notifications');
        const overlay = document.getElementById('overlay');

        overlay.classList.remove('show');
        notifications.classList.add('hide');

        setTimeout(() => {
            notifications.style.display = 'none';
            overlay.style.display = 'none';
            notifications.classList.remove('hide');
        }, 300);
    }

    function openNotificationsKeyframes() {
        const notifications = document.getElementById('notifications');
        const overlay = document.getElementById('overlay');

        overlay.style.display = 'block';
        notifications.style.display = 'flex';

        overlay.classList.add('fade-in');
        overlay.classList.remove('fade-out');
    }

    function closeNotificationsKeyframes() {
        const notifications = document.getElementById('notifications');
        const overlay = document.getElementById('overlay');

        overlay.classList.add('fade-out');
        overlay.classList.remove('fade-in');
        notifications.classList.add('hide');

        setTimeout(() => {
            notifications.style.display = 'none';
            overlay.style.display = 'none';
            notifications.classList.remove('hide');
            overlay.classList.remove('fade-out');
        }, 300);
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
<div class="nav-container">
    <nav class="nav">
        <div class="nav-left">
            <p class="app-icon">Laravel Auth Template</p>
        </div>
        <div class="nav-right">
            @if(Auth::user())
                <div class="profile">
                    <div class="profile-header" onclick="openProfileDropdown()">
                        <i class="fa-solid fa-circle-user" id="profile-button"></i>
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
            @else
                <div class="profile">
                    <div class="profile-header" onclick="openProfileDropdown()">
                        <i class="fa-solid fa-circle-user" id="profile-button"></i>
                    </div>

                    <div class="profile-dropdown" id="profile-dropdown">
                        <div class="dropdown-info">
                            <i class="fa-solid fa-circle-user icon"></i>
                            <p>Account</p>
                        </div>
                        <div class="divider"></div>
                        <a href="{{ route('login') }}" class="dropdown-button">
                            <i class="fa-solid fa-bed icon"></i>
                            <p>Login</p>
                        </a>
                        <a href="{{ route('register') }}" class="dropdown-button">
                            <i class="fa-solid fa-address-card icon"></i>
                            <p>Register</p>
                        </a>
                    </div>
                </div>
            @endif
            <div class="profile">
                <div class="profile-header" onclick="openNotifications()">
                    <i class="fa-regular fa-bell notifications">
                        <p class="notification-amount">9+</p>
                    </i>
                </div>
            </div>
        </div>
    </nav>

    <div class="overlay" id="overlay" onclick="closeNotifications()"></div>

    <div class="notifications-side" id="notifications">
        <h2 class="notifications-header">Notifications</h2>
        <i class="fa-solid fa-xmark close-button close-button" onclick="closeNotifications()"></i>
        <div class="divider"></div>

        <div class="notification-container">
            <div class="notification">
                <h3 class="notification-header">
                    Example wowww
                </h3>
                <div class="notification-content">
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua.
                </div>
            </div>

            <div class="notification">
                <h3 class="notification-header">
                    Example wowww
                </h3>
                <div class="notification-content">
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua.
                </div>
            </div>

            <div class="notification">
                <h3 class="notification-header">
                    Example wowww
                </h3>
                <div class="notification-content">
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua.
                </div>
            </div>
        </div>
    </div>

    <div class="layout">
        <div class="sidebar">
            <a href="{{ route('welcome') }}" class="button">
                <i class="fa-regular fa-house icon"></i>
                <div>Dashboard</div>
            </a>
            <a href="{{ route('file-upload') }}" class="button">
                <i class="fa-solid fa-upload icon"></i>
                <div>File Upload</div>
            </a>

            <a href="{{ route('file-list') }}" class="button">
                <i class="fa-solid fa-file-zipper icon"></i>
                <div>Files</div>
            </a>

            <a href="{{ route('admin.roles') }}" class="button">
                <i class="fa-solid fa-ruler icon"></i>
                <div>Roles</div>
            </a>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>
