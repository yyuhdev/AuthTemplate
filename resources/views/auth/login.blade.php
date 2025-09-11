@extends('template.auth')

@section('content')
    <script>
        function login() {
            const passwordEl = document.getElementById("password")
            const identificationEl = document.getElementById("identification")

            const password = passwordEl.value
            const identification = identificationEl.value;

            if (identification === '' ||
                password === ''
            ) {
                err("All fields must be filled out");
                return
            }

            setLoadingState(true);


            axios.post('{{ route('auth.login') }}',
                new URLSearchParams({
                    identification: identification,
                    password: password,
                }))
                .then(res => {
                    location.href = '{{ route('welcome') }}'
                })
                .catch(thr => {
                    err(thr.response.data.message)
                })
                .finally(() => {
                    setLoadingState(false);
                });
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
                buttonTextEl.textContent = 'Sending...';
                loadingSpinnerEl.style.display = 'inline-block';
            } else {
                buttonEl.disabled = false;
                buttonEl.classList.remove('button-loading');
                buttonTextEl.textContent = 'Login';
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


    <div class="input-form">
        <h1>Login</h1>
        <div class="input-pair">
            <label for="identification">Email or Username</label>
            <input type="text" name="identification" id="identification" placeholder="Enter Email or Username...">
        </div>

        <div class="input-pair">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter Password...">
        </div>

        <div class="input-form-actions">
            <button id="send-button" onclick="login()">
                <span class="loading-spinner" id="loading-spinner" style="display: none;"></span>
                <span id="button-text">Login</span>
            </button>
            <div class="text">
                <p>Forgot your Password?</p>
                <a href="{{ route('password.request')  }}">Reset here!</a>
            </div>
            <div class="text">
                <p>Don't have an Account?</p>
                <a href="{{ route('register')  }}">Registere here!</a>
            </div>
        </div>
    </div>
@endsection
