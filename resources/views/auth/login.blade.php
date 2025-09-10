@extends('template.default')

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

            axios.post('{{ route('auth.login') }}',
                new URLSearchParams({
                    identification: identification,
                    password: password,
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
            <button onclick="login()">Login</button>
            <div class="text">
                <p>Don't have an Account?</p>
                <a href="{{ route('register')  }}">Registere here!</a>
            </div>
        </div>
    </div>
@endsection
