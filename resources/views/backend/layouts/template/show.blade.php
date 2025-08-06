@extends('backend.app')

@section('title', 'Template Show')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Template Show</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Template</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row justify-content-center mt-4">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="card-title mb-0" style="text-align: center">{{ ucfirst($data->type) }}</h3>                    
                </div>
                <div class="card-body p-4">
                    <p class="text-muted fs-5">{!! $data->message !!}</p>
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="{{ route('template.index') }}" class="btn btn-outline-primary px-4 py-2">Back to Templates</a>
                </div>
            </div>
        </div>
    </div>
    
@endsection

