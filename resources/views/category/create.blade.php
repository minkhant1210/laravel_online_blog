@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        Add Category
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category.store') }}" method="post">
                            @csrf
                            <div class="row align-items-end">
                                <div class="col-12 col-md-6">
                                    <label for="title" class="form-label">Add Category</label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" required autofocus>
                                </div>
                                <div class="col-12 col-md-6">
                                    <button class="btn btn-primary">Add Category</button>
                                </div>
                            </div>
                        </form>
                        @error('title')
                            <small class="alert alert-danger d-block mt-2 w-50">{{ $message }}</small>
                        @enderror
{{--                        @if(session('status'))--}}
{{--                            <small class="alert alert-success d-block mt-2 w-50">{{ session('status') }}</small>--}}
{{--                            @endif--}}
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        Latest Category List
                    </div>
                    <div class="card-body">
                        @if(session('deleteStatus'))
                            <p class="alert alert-danger small">{{ session('deleteStatus') }}</p>
                        @endif
                        @if(session('status'))
                            <p class="alert alert-success small">{{ session('status') }}</p>
                        @endif
                        <table class="table table-hover table-bordered align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Owner</th>
                                <th>Controls</th>
                                <th>Created At:</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td>{{ $category->user->name }}</td>
                                    <td>
                                        <form action="{{ route('category.destroy',$category->id) }}" method="post" class="d-inline-block">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt fa-fw"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('category.edit',$category->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-pen-alt fa-fw"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <p class="small mb-0">
                                            <i class="fas fa-calendar text-primary"></i>
                                            {{ $category->created_at->format('d-M-Y') }}
                                        </p>
                                        <p class="small mb-0">
                                            <i class="fas fa-clock text-primary"></i>
                                            {{ $category->created_at->format('h:m A') }}
                                        </p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <h5 class="mb-0 fw-bold">There is no category</h5>
                                    </td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="5" class="text-center">
                                    <a href="{{ route('category.index') }}" class="btn btn-primary">
                                        View All Categories
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
