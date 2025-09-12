@extends('template.auth')

@section('content')

    <script>
        function resetPassword() {
            setLoadingState(true);
            const password_confirmationEl = document.getElementById('password_confirmation');
            const passwordEl = document.getElementById('password');
            const emailEl = document.getElementById('email');
            const token = '{{ $token }}'

            const password_confirmation = password_confirmationEl.value;
            const password = passwordEl.value;
            const email = emailEl.value;

            axios.post('{{ route('auth.update-password') }}',
                new URLSearchParams({
                    password: password,
                    password_confirmation: password_confirmation,
                    email: email,
                    token: token,
                }))
                .then(response => {
                    console.log(response);
                    success(response.data.message);
                })
                .catch(error => {
                    console.log(error)
                    err(error.response.data.message);
                })
                .finally(() => {
                    setLoadingState(false);
                });
        }

        function err(message) {
            const errorEl = document.getElementById("alert")
            const errorText = document.getElementById("alert-text")

            errorText.innerText = message
            errorEl.style.display = "block";
            setTimeout(() => {
                errorEl.style.display = "none";
            }, 5000);
        }


        function success(message) {
            const errorEl = document.getElementById("success")
            const errorText = document.getElementById("success-text")

            errorText.innerText = message
            errorEl.style.display = "block";
            setTimeout(() => {
                errorEl.style.display = "none";
            }, 5000);
        }

        function closeErr() {
            const errorEl = document.getElementById("alert");
            errorEl.style.display = "none";
        }

        function setLoadingState(loading) {
            const buttonEl = document.getElementById('send-button');
            const buttonTextEl = document.getElementById('button-text');
            const loadingSpinnerEl = document.getElementById('loading-spinner');

            if (loading) {
                buttonEl.disabled = true;
                buttonEl.classList.add('button-loading');
                buttonTextEl.textContent = 'Loading...';
                loadingSpinnerEl.style.display = 'inline-block';
            } else {
                buttonEl.disabled = false;
                buttonEl.classList.remove('button-loading');
                buttonTextEl.textContent = 'Reset Password';
                loadingSpinnerEl.style.display = 'none';
            }
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
                <i class="fa-solid fa-xmark close-button" onclick="closeErr()"></i>
            </div>
        </div>
        <p id="alert-text" class="alert-text">There has been an issue creating your Account!</p>
    </div>

    <div class="alert" id="success">
        <div class="alert-top">
            <div class="alert-top-left">
                <p class="success-header">
                    <i class="fa-solid fa-thumbs-up"></i> Info
                </p>
            </div>
            <div class="alert-top-right">
                <i class="fa-solid fa-xmark close-button" onclick="closeErr()"></i>
            </div>
        </div>
        <p id="success-text" class="alert-text">There has been an issue creating your Account!</p>
    </div>

    <div class="input-form">
        <h1>Reset Password</h1>


        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-pair">
            <label for="email">Your Email</label>
            <input name="email" id="email" type="email" placeholder="Enter your Email..." value="{{ old('email') }}"
                   required autofocus>
        </div>

        <div class="input-pair">
            <label for="password">New Password</label>
            <input name="password" id="password" type="password" placeholder="Enter new password..." required>
        </div>

        <div class="input-pair">
            <label for="password_confirmation">Confirm Password</label>
            <input name="password_confirmation" id="password_confirmation" type="password"
                   placeholder="Confirm new password..." required>
        </div>

        <div class="input-form-actions">
            <button id="send-button" onclick="resetPassword()">
                <span class="loading-spinner" id="loading-spinner" style="display: none;"></span>
                <span id="button-text">Reset Password</span>
            </button>
        </div>
    </div>
@endsection
