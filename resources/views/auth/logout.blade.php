@extends('template.default')

@section('content')
    <script>
        function logout() {
            axios.post('{{ route('auth.logout')  }}')
                .then(data => {
                    console.log(data)
                })
        }
    </script>

    <div class="input-form">
        <h1>Logout</h1>
        <p>Log out of your Account.</p>
        <div class="input-form-actions">
            <button onclick="logout()">Logout</button>
        </div>
    </div>
@endsection
