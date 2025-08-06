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
                    <form action="{{ route('about.banner.update', $data->id) }}" method="POST"
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
                                <label for="about_page_title">About Banner Title</label>
                                <input type="text" name="about_page_title" id="about_page_title" class="form-control"
                                    value="{{ old('about_page_title', $data->about_page_title) }}">
                            </div>
                            @error('about_page_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="about_page_banner">About Page Banner</label>
                                <input type="file" name="about_page_banner" class="form-control dropify"
                                    data-default-file="{{ asset($data->about_page_banner) }}">
                                @error('about_page_banner')
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
