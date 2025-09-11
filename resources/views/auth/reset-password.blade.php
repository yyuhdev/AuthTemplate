@extends('template.default')

@section('content')
    <div class="input-form">
        <h1>Reset Password</h1>

        @if ($errors->any())
            <div class="alert" id="alert">
                <div class="alert-top">
                    <div class="alert-top-left">
                        <p class="alert-header">
                            <i class="fa-solid fa-triangle-exclamation"></i> Error
                        </p>
                    </div>
                </div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li id="alert-text">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('auth.update-password') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="input-pair">
                <label for="email">Your Email</label>
                <input name="email" id="email" type="email" placeholder="Enter your Email..." value="{{ old('email') }}" required autofocus>
            </div>

            <div class="input-pair">
                <label for="password">New Password</label>
                <input name="password" id="password" type="password" placeholder="Enter new password..." required>
            </div>

            <div class="input-pair">
                <label for="password_confirmation">Confirm Password</label>
                <input name="password_confirmation" id="password_confirmation" type="password" placeholder="Confirm new password..." required>
            </div>

            <div class="input-form-actions">
                <button type="submit">Reset Password</button>
            </div>
        </form>
    </div>
@endsection
