@extends('template.default')

@section('content')
    <script>
        function updateUsername() {
            const usernameEl = document.getElementById('username');
            const username = usernameEl.value;

            const passwordEl = document.getElementById('password');
            const password = passwordEl.value;

            const emailEl = document.getElementById('email');
            const email =  emailEl.value;

            axios.post('{{ route('profile.update-username') }}',
                new URLSearchParams({
                    name: username,
                    password: password,
                    email: email,
                }),
            ).then(response => {
                console.log(response);
                location.href = '{{ route('welcome')  }}';
            }).catch(error => {
                err(error.response.data.message)
            });
        }

        function updatePassword() {
            const passwordEl = document.getElementById('password');
            const password = passwordEl.value;

            const newPasswordEl = document.getElementById('new_password');
            const rNewPasswordEl = document.getElementById('rnew_password');

            const newPassword = newPasswordEl.value;
            const rnewPassword = rNewPasswordEl.value;

            axios.post('{{ route('profile.update-password') }}',
                new URLSearchParams({
                    current_password: password,
                    password: newPassword,
                    password_confirmation: rnewPassword,
                })
            ).then(response => {
                console.log(response);
                location.href = '{{ route('welcome')  }}';
            }).catch(error => {
                err(error.response.data.message)
            });
        }

        function updateProfile() {
            const actionEl = document.getElementById('action');
            const action = actionEl.value;

            if (action === "username") {
                updateUsername();
            }

            if (action === "password") {
                updatePassword();
            }
        }

        function showPasswordModal(action) {
            const container = document.getElementById('settings-container');
            container.style.display = 'none';

            const passwordEl = document.getElementById('password-modal');
            passwordEl.style.display = 'flex';

            const actionEl = document.getElementById('action');
            actionEl.value = action;

            const emailEl = document.getElementById('email');
            emailEl.value = '{{ Auth::user()->email }}';
        }

        function closePasswordModal() {
            const container = document.getElementById('settings-container');
            container.style.display = 'flex';

            const passwordEl = document.getElementById('password-modal');
            passwordEl.style.display = 'none';
        }

        function err(message) {
            const errorEl = document.getElementById("alert");
            const errorText = document.getElementById("alert-text");

            errorText.innerText = message;
            errorEl.style.display = "block";
            setTimeout(() => {
                errorEl.style.display = "none";
            }, 5000);
        }
    </script>

    <div class="alert" id="alert">
        <div class="alert-top">
            <div class="alert-top-left">
                <p class="alert-header">
                    <i class="fa-solid fa-triangle-exclamation"></i> Error
                </p>
            </div>
            <div class="alert-top-right">
                <i class="fa-solid fa-xmark close-button"></i>
            </div>
        </div>
        <p id="alert-text" class="alert-text">There has been an issue creating your Account!</p>
    </div>

    <div class="input-form" id="password-modal" style="display: none">
        <h1>Confirm Changes</h1>
        <div class="input-pair">
            <label for="email">Email</label>
            <input name="email" id="email" type="email" disabled content="{{ Auth::user()->email }}">
        </div>
        <div class="input-pair">
            <label for="password">Password</label>
            <input name="password" id="password" type="password" placeholder="Enter current Password...">
        </div>
        <input name="action" id="action" type="hidden">
        <div class="input-form-actions">
            <button onclick="updateProfile()">Confirm</button>
            <button onclick="closePasswordModal()">Back</button>
        </div>
    </div>

    <div class="settings-container" id="settings-container">
        <div class="input-form">
            <h1>Reset Username</h1>
            <div class="input-pair">
                <label for="username">Username</label>
                <input name="username" id="username" type="text" placeholder="Enter new Username...">
            </div>
            <div class="input-form-actions">
                <button onclick="showPasswordModal('username')">Update Username</button>
            </div>
        </div>

        <div class="input-form">
            <h1>Change Password</h1>
            <div class="input-pair">
                <label for="new_password">New Password</label>
                <input name="new_password" id="new_password" type="password" placeholder="Enter new Password...">
            </div>
            <div class="input-pair">
                <label for="rnew_password">Repeat New Password</label>
                <input name="rnew_password" id="rnew_password" type="password" placeholder="Repeat new Password...">
            </div>
            <div class="input-form-actions">
                <button onclick="showPasswordModal('password')">Change Password</button>
            </div>
        </div>
    </div>
@endsection
