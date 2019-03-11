@extends('layouts.app')
@section('content')

<div class="container">
    <div class="card">
    <div class="card-body">
        <h5 class="card-title">Pages <a href="/pages/create" class="float-right">Add Page</a></h5>
        <p class="card-text">
           <div class="d-table">
            @foreach ($Pages as $page)
            <div class="d-table-row">
                <div class="d-table-cell">
                    <a href="{{ $page->url }}" class="link d-table-cell" _target="_blank">{{ $page->title }}</a>
                </div>
                <div class="d-table-cell text-right">                    
                    <a href="/pages/{{ $page->id }}/edit" class="badge badge-primary mx-2 py-1"><i class="fa fa-cog"></i></a>
                    <a href="/pages/{{ $page->id }}" class="badge badge-primary mx-2 py-1"><i class="fa fa-pencil"></i></a>
                    <a href="{{ $page->url }}" class="badge badge-primary mx-2 py-1" target="_blank"><i class="fa fa-external-link"></i></a>
                </div>
            </div>
            @endforeach
           </div>
        </p>
    </div>
</div>
</div>
@endsection
