@extends('template.default')

@section('content')
    <script>
        function sendEmailVerification() {
            axios.post('/email/verification-notification')
                .then(data => {
                    console.log(data)
                })
        }
    </script>

    <div class="input-form">
        <h1>Verify Email</h1>
        <p>Verify your Email.</p>
        <div class="input-form-actions">
            <button onclick="sendEmailVerification()">Verify Email</button>
        </div>
    </div>
@endsection
