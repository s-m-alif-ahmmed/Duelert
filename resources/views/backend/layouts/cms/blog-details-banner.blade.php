@extends('backend.app')

@section('title', 'Edit Banner')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Banner</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">Banner</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('blog.details.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="blog_details_title">Blog Details Banner Title</label>
                                <input type="text" name="blog_details_title" id="blog_details_title" class="form-control"
                                    value="{{ old('blog_details_title', $data->blog_details_title) }}">
                            </div>
                            @error('blog_details_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="blog_details_banner">Blog Details Banner</label>
                                <input type="file" name="blog_details_banner" class="form-control dropify"
                                    data-default-file="{{ asset($data->blog_details_banner) }}">
                                @error('blog_details_banner')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Banner</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@endpush
