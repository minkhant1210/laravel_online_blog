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
                        <form action="{{ route('category.update',$category->id) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="row align-items-end">
                                <div class="col-12 col-md-6">
                                    <label for="title" class="form-label">Edit Category</label>
                                    <input type="text" name="title" id="title" value="{{ old('title',$category->title) }}" class="form-control @error('title') is-invalid @enderror" required autofocus>
                                </div>
                                <div class="col-12 col-md-6">
                                    <button class="btn btn-primary">Update Category</button>
                                </div>
                            </div>
                        </form>
                        @error('title')
                        <small class="alert alert-danger d-block mt-2 w-50">{{ $message }}</small>
                        @enderror
                        @if(session('status'))
                            <small class="alert alert-success d-block mt-2 w-50">{{ session('status') }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
