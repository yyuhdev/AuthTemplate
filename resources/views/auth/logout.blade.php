@extends('template.auth')

@section('content')
    <script>
        function logout() {
            setLoadingState(true);
            axios.post('{{ route('auth.logout')  }}')
                .then(data => {
                    location.href = '{{ route('welcome') }}'
                })
                .finally(() => {
                    setLoadingState(false);
                })
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
                buttonTextEl.textContent = 'Logout';
                loadingSpinnerEl.style.display = 'none';
            }
        }
    </script>

    <div class="input-form">
        <h1>Logout</h1>
        <p>Log out of your Account.</p>
        <div class="input-form-actions">
            <button id="send-button" onclick="logout()">
                <span class="loading-spinner" id="loading-spinner" style="display: none;"></span>
                <span id="button-text">Logout</span>
            </button>
            <div class="text">
                <p>Want to come back?</p>
                <a href="{{ route('welcome')  }}">Return Here!</a>
            </div>
        </div>
    </div>
@endsection
