@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-1">
                            {{ \Illuminate\Support\Str::words($post->title,10) }}
                        </h5>

                        <div class="text-black-50">
                            <small class="">
                                <i class="fas fa-user-alt text-primary"></i>
                                {{ $post->user->name }}
                            </small>
                            <small class="mx-2">
                                <i class="fas fa-layer-group text-primary"></i>
                                {{ $post->category->title }}
                            </small>
                            <small class="">
                                <i class="fas fa-clock text-primary"></i>
                                {{ $post->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-black-50">
                            {{ $post->description }}
                        </p>
                        <hr>
                        <div class="w-100 text-end">
                            <a href="{{ route('post.create') }}" class="btn btn-primary">
                                Create Post
                            </a>
                            <a href="{{ route('post.index') }}" class="btn btn-outline-primary">
                                All Post
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
