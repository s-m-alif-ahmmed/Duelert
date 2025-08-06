@extends('backend.app')

@section('title', 'Our key highlight')

@section('content')

    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Our key highlight Edit Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Our key highlight</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER END --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">

                    <form action="{{ route('key-highlight.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   name="title" placeholder="Enter title" id="title"
                                   value="{{ old('title', $item->title) }}" required>
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                                   name="subtitle" placeholder="Enter subtitle" id="subtitle"
                                   value="{{ old('subtitle', $item->subtitle) }}" required>
                            @error('subtitle')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control dropify"
                                   data-default-file="{{ asset($item->image) }}">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="body_title" class="form-label">Body Title</label>
                            <input type="text" class="form-control @error('body_title') is-invalid @enderror"
                                   name="body_title" placeholder="Enter body title" id="body_title"
                                   value="{{ old('body_title', $item->body_title) }}" required>
                            @error('body_title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="file" name="icon" id="icon" class="form-control dropify"
                                   data-default-file="{{ asset($item->icon) }}">
                            @error('icon')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Enter description" required>{{ old('description', $item->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

