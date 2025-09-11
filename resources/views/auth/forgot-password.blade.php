@extends('template.default')

@section('content')
    <script>
        function sendEmail() {
            const emailEl = document.getElementById('email');
            const email = emailEl.value;

            if (email === "") {
                err("Please enter a valid email address!");
                return;
            }

            axios.post('{{ route('password.email') }}',
                new URLSearchParams({
                    email: email,
                })
            )
                .then(data => {
                    console.log(data)
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
        <h1>Reset Password</h1>
        <div class="input-pair">
            <label for="email">Your Email</label>
            <input name="email" id="email" type="email" placeholder="Enter your Email...">
        </div>
        <div class="input-form-actions">
            <button onclick="sendEmail()">Send Email</button>
        </div>
    </div>
@endsection
