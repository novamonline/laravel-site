@extends('layouts.main')

@section('content')
    <login :route="{ 'password': '{{ route('password.request') }}' }"></login>
@endsection