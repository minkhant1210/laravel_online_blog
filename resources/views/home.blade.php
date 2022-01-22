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
                        <x-alert>
                            Testing slot
                        </x-alert>
                        <x-alert class="alert-warning mb-5">
                            Alert 1
                        </x-alert>
                        <x-alert class="alert-danger">
                            Alert 2
                        </x-alert>
                        <hr>
                    {{ $categories }}
                        <hr>
                    @mkz
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        console.log('this is stack and push');
    </script>
@endpush
