@extends('backend.app')

@section('title', 'Blog Edit')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Blog Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('blog.update', ['id' => $data->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="title" class="form-label">Blog Title:</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   name="title" placeholder="Blog Title" id="title" value="{{ old('title', $data->title) }}">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="summernote" class="form-label">Blog Description:</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="summernote" placeholder="Blog Description" cols="30" rows="3">{{ old('description', $data->description) }}</textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image" class="form-label">Blog Image:</label>
                            <input type="file" class="form-control dropify @error('image') is-invalid @enderror" name="image" id="image" data-default-file="{{ asset($data->image) }}">
                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('blog.index') }}" class="btn btn-danger me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
