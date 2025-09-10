@extends('template.default')

@section('content')
    <script>
        function register() {
            const passwordEl = document.getElementById("password")
            const rpasswordEl = document.getElementById("rpassword")
            const nameEl = document.getElementById("username")
            const emailEl = document.getElementById("email")

            const password = passwordEl.value
            const name = nameEl.value
            const repeatedPassword = rpasswordEl.value;
            const email = emailEl.value;

            if (name === '' ||
                email === '' ||
                repeatedPassword === '' ||
                password === ''
            ) {
                err("All fields must be filled out");
                return
            }

            if (password !== repeatedPassword) {
                err("Passwords don't match!");
                return;
            }

            if (password.length <= 8) {
                err("Your Password is too short!");
                return;
            }

            axios.post('{{ route('auth.register') }}',
                new URLSearchParams({
                    email: email,
                    name: name,
                    password: password,
                    password_confirmation: repeatedPassword,
                }))
                .then(res => {
                    console.log(res)
                })
                .catch(thr => {
                    err(thr.response.data.message)
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

    <div class="input-form">
        <h1>Register</h1>
        <div class="input-pair">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter Email...">
        </div>

        <div class="input-pair">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Enter Username...">
        </div>

        <div class="input-pair">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter Password...">
        </div>

        <div class="input-pair">
            <label for="rpassword">Repeat Password</label>
            <input type="password" name="rpassword" id="rpassword" placeholder="Repeat Password...">
        </div>

        <div class="input-form-actions">
            <button onclick="register()">Register</button>
            <div class="text">
                <p>Already have an Account?</p>
                <a href="{{ route('login')  }}">Login here!</a>
            </div>
        </div>
    </div>
@endsection
