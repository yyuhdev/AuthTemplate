@extends('template.default')

@section('content')
    <h2 style="font-weight: normal">Logged in:
        @if(Auth::user())
            <span style="color: lawngreen">True</span>
        @else
            <span style="color: red">False</span>
        @endif
    </h2>
    @if(Auth::user())
        <h2 style="font-weight: normal">Verified Email:
            @if(Auth::user()->hasVerifiedEmail())
                <span style="color: lawngreen">True</span>
            @else
                <span style="color: red">False</span>
            @endif
        </h2>
        <h2 style="font-weight: normal">Name: {{ Auth::user()->name }}</h2>
    @endif
@endsection
