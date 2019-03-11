@extends('layouts.site')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Site Templates</h5>
            <p class="card-text">{{ __('Select or Create new Templates here') }}</p>
            {!! $content !!}           
        </div>
    </div>
</div>
@endsection