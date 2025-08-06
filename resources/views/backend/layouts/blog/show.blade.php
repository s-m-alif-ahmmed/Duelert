@extends('backend.app')

@section('title', 'Blog Show')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Blog Show</h1>
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
                    {{-- Blog Title --}}
                    <h4 class="mb-3" style="font-weight: bold;">{{ $data->title }}</h4>

                      {{-- Blog Image --}}
                      @if($data->image)
                      <div class="mb-3">
                          <img src="{{ asset($data->image) }}" alt="Blog Image" class="img-fluid" style="max-width: 100%;">
                      </div>
                  @else
                      <p>No image available</p>
                  @endif

                    {{-- Blog Description --}}
                    <p>{{ $data->description }}</p>

                  

                    {{-- Back Button --}}
                    <a href="{{ route('blog.index') }}" class="btn btn-danger">Back to Blogs</a>
                </div>
            </div>
        </div>
    </div>
@endsection
