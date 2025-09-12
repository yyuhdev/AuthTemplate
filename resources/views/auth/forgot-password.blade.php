@extends('template.auth')

@section('content')
    <script>
        function sendEmail() {
            const emailEl = document.getElementById('email');
            const email = emailEl.value;

            if (email === "") {
                err("Please enter a valid email address!");
                return;
            }

            setLoadingState(true);

            axios.post('{{ route('password.email') }}',
                new URLSearchParams({
                    email: email,
                }))
                .then(data => {
                    success(data.data.message);
                })
                .catch(error => {
                    err(error.response.data.message);
                })
                .finally(() => {
                    setLoadingState(false);
                })
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
                buttonTextEl.textContent = 'Send Email';
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
        <div class="input-pair">
            <label for="email">Your Email</label>
            <input name="email" id="email" type="email" placeholder="Enter your Email...">
        </div>
        <div class="input-form-actions">
            <button id="send-button" onclick="sendEmail()">
                <span class="loading-spinner" id="loading-spinner" style="display: none;"></span>
                <span id="button-text">Send Email</span>
            </button>
            <div class="text">
                <p>Remembered your password?</p>
                <a href="{{ route('login') }}">Back to login</a>
            </div>
        </div>
    </div>
@endsection
