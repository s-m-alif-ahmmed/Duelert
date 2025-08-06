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
                    <form action="{{ route('home.banner.update', $data->id) }}" method="POST"
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="home_banner_title">Home Banner Title</label>
                                    <input type="text" name="home_banner_title" id="home_banner_title"
                                        class="form-control"
                                        value="{{ old('home_banner_title', $data->home_banner_title) }}" required>
                                </div>
                                @error('home_banner_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button_text">Button Text</label>
                                    <input type="text" name="button_text" id="button_text" class="form-control"
                                        value="{{ old('button_text', $data->button_text) }}" required>
                                </div>
                                @error('button_text')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="home_banner_subtitle">Home Banner Subtitle</label>
                                    <input type="text" name="home_banner_subtitle" id="home_banner_subtitle"
                                        class="form-control"
                                        value="{{ old('home_banner_subtitle', $data->home_banner_subtitle) }}" required>
                                </div>
                                @error('home_banner_subtitle')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="home_banner">Home Banner</label>
                                    <input type="file" name="home_banner" class="form-control dropify"
                                        data-default-file="{{ asset($data->home_banner) }}">
                                    @error('home_banner')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="home_banner_two">Home Banner Two</label>
                                    <input type="file" name="home_banner_two" class="form-control dropify"
                                        data-default-file="{{ asset($data->home_banner_two) }}">
                                    @error('home_banner_two')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="home_banner_three">Home Banner Three</label>
                                    <input type="file" name="home_banner_three" class="form-control dropify"
                                        data-default-file="{{ asset($data->home_banner_three) }}">
                                    @error('home_banner_three')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="home_banner_four">Home Banner Four</label>
                                    <input type="file" name="home_banner_four" class="form-control dropify"
                                        data-default-file="{{ asset($data->home_banner_four) }}">
                                    @error('home_banner_four')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="home_banner_five">Home Banner Five</label>
                                    <input type="file" name="home_banner_five" class="form-control dropify"
                                        data-default-file="{{ asset($data->home_banner_five) }}">
                                    @error('home_banner_five')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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
