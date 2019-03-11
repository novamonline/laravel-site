@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>You are logged in!</p>
                    <p>
                        Go to <a href="/admin">My Dashboard</a>
                    </p>
                    <p>
                        Go to <a href="/pages">Pages Content</a>
                    </p>
                    <p>
                        Go to <a href="/sites">Site Templates</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
