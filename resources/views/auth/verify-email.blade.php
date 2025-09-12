@extends('template.auth')

@section('content')
    <script>
        function sendEmailVerification() {
            setLoadingState(true);
            axios.post('{{ route('verification.send') }}')
                .then(data => {
                    success("Email has been sent.");
                })
                .catch(error => {
                    console.log(error);
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
                buttonTextEl.textContent = 'Verify Email';
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
        <h1>Verify Email</h1>
        <p>Verify your Email.</p>
        <div class="input-form-actions">
            <button id="send-button" onclick="sendEmailVerification()">
                <span class="loading-spinner" id="loading-spinner" style="display: none;"></span>
                <span id="button-text">Verify Email</span>
            </button>
            <div class="text">
                <p>Wrong Account?</p>
                <a href="{{ route('logout')  }}">Logout Here!</a>
            </div>
        </div>
    </div>
@endsection
