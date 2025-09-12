@extends('template.default')

@section('content')
    <p>{{ \Illuminate\Foundation\Inspiring::quotes()[rand(1, \Illuminate\Foundation\Inspiring::quotes()->count()-41)] }}</p>
@endsection
