@extends('backend.app')

@section('title', 'Edit Value We Offer')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Value We Offer</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">Value We Offer</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('value.update', $data->id) }}" method="POST"
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        value="{{ old('title', $data->title) }}" required>
                                </div>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $data->description) }}</textarea>
                                </div>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image_one">Image One</label>
                                    <input type="file" name="image_one" class="form-control dropify"
                                        data-default-file="{{ asset($data->image_one) }}">
                                    @error('image_one')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image_two">Image Two</label>
                                    <input type="file" name="image_two" class="form-control dropify"
                                        data-default-file="{{ asset($data->image_two) }}">
                                    @error('image_two')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@endpush
