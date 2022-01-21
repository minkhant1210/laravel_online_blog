@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        Edit Post
                    </div>
                    <div class="card-body">
                        <form action="{{ route('post.update',$post->id) }}" id="updateForm" method="post">
                            @csrf
                            @method('put')
                        </form>
{{--                            <div class="mb-3">--}}
{{--                                <label for="title" class="form-label">Post Title</label>--}}
{{--                                <input type="text" name="title" id="title" form="updateForm" value="{{ old('title',$post->title) }}" class="form-control @error('title') is-invalid @enderror" required autofocus>--}}
{{--                                @error('title')--}}
{{--                                <small class="text-danger fw-bold"> {{ $message }}</small>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                            <x-input name="title" input-title="Post Title" form="updateForm" value="{{ $post->title }}"></x-input>
                            <div class="mb-3">
                                <label for="category" class="form-label">Select Category</label>
                                <select name="category" id="category" form="updateForm" class="form-select @error('category') is-invalid @enderror">
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ old('category',$post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
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
                                    <input class="form-check-input" type="checkbox" value="{{ $tag->id }}" form="updateForm" name="tags[]" id="tag{{ $tag->id }}" {{ in_array($tag->id,old('tags',$post->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
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

                        <label for="" class="form-label">Post Photo</label>

                            <div class="border rounder p-3 d-flex overflow-scroll">
                                <form action="{{ route('photo.store') }}" class="d-none" id="photoUploadForm" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <div class="mb-3">
                                        <label for="photoInput" class="form-label">Photo</label>
                                        <input type="file" name="photos[]" id="photoInput" class="form-control @error('photos') is-invalid @enderror" required autofocus multiple>
                                        @error('photos')
                                        <small class="text-danger fw-bold"> {{ $message }}</small>
                                        @enderror
                                        @error('photos.*')
                                        <small class="text-danger fw-bold"> {{ $message }}</small>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary">Upload</button>
                                </form>
                                <div class="border border-2 px-3 border-dark rounded uploader-ui me-1 d-flex justify-content-center align-items-center" id="photoUploadUi">
                                    <i class="fas fa-plus fa-2x"></i>
                                </div>

                                @forelse($post->photos as $photo)
                                    <div class="position-relative">
                                        <form action="{{ route('photo.destroy',$photo->id) }}" class="position-absolute start-0 bottom-0" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        <a class="venobox" data-gall="img{{ $post->id }}" href="{{ asset('storage/photo/'.$photo->name) }}">
                                            <img src="{{ asset('storage/thumbnail/'.$photo->name) }}" height="100" class="rounded me-1" alt="image alt"/>
                                        </a>
                                    </div>
                                @empty
                                @endforelse
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" form="updateForm" class="form-control" rows="10">{{ old('description',$post->description) }}</textarea>
                                @error('description')
                                <small class="text-danger fw-bold">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" required>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Confirm</label>
                                </div>
                                <button class="btn btn-lg btn-primary" form="updateForm">Update Post</button>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        let photoUploadForm = document.getElementById('photoUploadForm');
        let photoInput = document.getElementById('photoInput');
        let photoUploadUi = document.getElementById('photoUploadUi');

        photoUploadUi.addEventListener("click",function (){
            photoInput.click();
        })
        photoInput.addEventListener("change",function (){
            photoUploadForm.submit();
        })


    </script>
@endsection

