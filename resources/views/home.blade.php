@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                        <hr>
                        <x-alert></x-alert>
                        <x-alert class="alert-warning"></x-alert>
                        <x-alert class="alert-danger"></x-alert>
                        <hr>
                    {{ $categories }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
