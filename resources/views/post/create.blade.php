@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        Create Post
                    </div>
                    <div class="card-body">
                        <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @csrf
{{--                            <div class="mb-3">--}}
{{--                                <label for="title" class="form-label">Post Title</label>--}}
{{--                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" required autofocus>--}}
{{--                                @error('title')--}}
{{--                                <small class="text-danger fw-bold"> {{ $message }}</small>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                                <x-input name="title" input-title="Post Title" ></x-input>
                            <div class="mb-3">
                                <label for="category" class="form-label">Select Category</label>
                                <select name="category" id="category" class="form-select @error('category') is-invalid @enderror">
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <small class="text-danger fw-bold">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tags" class="form-label">Select Tags</label>
                                <br>
                                @foreach(\App\Models\Tag::all() as $tag)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" value="{{ $tag->id }}" name="tags[]" id="tag{{ $tag->id }}" {{ in_array($tag->id, old("tags",[])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tag{{ $tag->id }}">
                                            {{ $tag->title }}
                                        </label>
                                    </div>
                                @endforeach
                                <br>
                                @error('tags')
                                <small class="text-danger fw-bold"> {{ $message }}</small>
                                @enderror
                                @error('tags.*')
                                <small class="text-danger fw-bold"> {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Post Photo</label>
                                <input type="file" name="photos[]" id="photo" class="form-control @error('photos') is-invalid @enderror" multiple>
                                @error('photos')
                                <small class="text-danger fw-bold"> {{ $message }}</small>
                                @enderror
                                @error('photos.*')
                                <small class="text-danger fw-bold"> {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="10">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="text-danger fw-bold">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" required>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Confirm</label>
                                </div>
                                <button class="btn btn-lg btn-primary">Create Post</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
