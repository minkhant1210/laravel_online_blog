@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Post List
                    </div>
                    <div class="card-body">

                            <div class="mb-3 d-flex justify-content-between">

                                <div class="">
                                    <a href="{{ route('post.create') }}" class="btn btn-primary">
                                        Create Post
                                    </a>
                                    @isset(request()->search)
                                        <a href="{{ route('post.index') }}" class="btn btn-outline-primary mr-3">
                                            <i class="feather-list"></i>
                                            All Post
                                        </a>
                                        <span>Search By : " {{ request()->search }} "</span>
                                    @endisset
                                </div>
                                <form method="get" class="w-25">
                                    <div class="input-group ">
                                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search Something">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search fa-fw"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>


{{--                        @if(session('deleteStatus'))--}}
{{--                            <p class="alert alert-danger small">{{ session('deleteStatus') }}</p>--}}
{{--                        @endif--}}
{{--                        @if(session('status'))--}}
{{--                            <p class="alert alert-success small">{{ session('status') }}</p>--}}
{{--                        @endif--}}
                        <table class="table table-hover table-bordered align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="w-25">Title</th>
                                <th>Photos</th>
                                <th>Is Published</th>
                                <th>Category</th>
                                <th>Tags</th>
                                <th>Owner</th>
                                <th>Controls</th>
                                <th>Created At:</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->short_title }}</td>
                                    <td class="text-nowrap">
{{--                                        @forelse($post->photos()->latest('id')->limit(3)->get() as $photo)--}}
                                        {{-- for eager loading --}}
                                        @forelse($post->photos as $key=>$photo)
                                            @if($key === 3)
                                                @break
                                            @endif
                                            <a class="venobox" data-gall="img{{ $post->id }}" href="{{ asset('storage/photo/'.$photo->name) }}">
                                                <img src="{{ asset('storage/thumbnail/'.$photo->name) }}" height="30" class="rounded-circle border border-2 border-white shadow-sm list-thumbnail" alt="image alt"/>
                                            </a>
                                        @empty
                                            <p class="text-muted mb-0">No photo</p>
                                        @endforelse
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $post->is_published ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">
                                                {{ $post->is_published ? 'Published' : 'Unpublished' }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ $post->category->title ?? "Unknown Category" }}</td>
                                    <td>
                                        @foreach($post->tags as $tag)
                                            <span class="badge bg-primary small">
                                                <i class="fas fa-hashtag"></i>
                                                {{ $tag->title }}
                                            </span>
                                            @endforeach
                                    </td>
                                    <td>{{ $post->user->name ?? "Unknown User" }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('post.show',$post->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-info-circle fa-fw text-info"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-primary" form="postDeleteForm{{ $post->id }}">
                                                <i class="fas fa-trash-alt fa-fw text-danger"></i>
                                            </button>
                                            <a href="{{ route('post.edit',$post->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-pen-alt fa-fw text-warning"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <form action="{{ route('post.destroy',$post->id) }}" id="postDeleteForm{{ $post->id }}" method="post" class="d-inline-block">
                                        @csrf
                                        @method('delete')

                                    </form>
                                    <td class="text-nowrap">
                                        {!! $post->show_time !!}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <h5 class="mb-0 fw-bold">There is no category</h5>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div>
                            {{ $posts->appends(request()->all())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
